<?

namespace Passengers\Model\Behavior;

use Tools\Model\Behavior\PasswordableBehavior as OriginalPasswordableBehavior;

class PasswordableBehavior extends OriginalPasswordableBehavior {

    protected $_validationRules = [
        'formField' => [
            'between' => [
                'rule' => ['lengthBetween', PWD_MIN_LENGTH, PWD_MAX_LENGTH],
                'message' => ['Please provide password with length between {0} and {1} chars.', PWD_MIN_LENGTH, PWD_MAX_LENGTH],
                'last' => true,
                //'provider' => 'table'
            ]
        ],
        'formFieldRepeat' => [
            'validateIdentical' => [
                'rule' => ['validateIdentical', ['compare' => 'formField']],
                'message' => 'Provided passwords do not match.',
                'last' => true,
                'provider' => 'table'
            ],
        ],
        'formFieldCurrent' => [
            'notBlank' => [
                'rule' => ['notBlank'],
                'message' => 'Please provide the current password.',
                'last' => true,
            ],
            'validateCurrentPwd' => [
                'rule' => 'validateCurrentPwd',
                'message' => 'The current password is not correct',
                'last' => true,
                'provider' => 'table'
            ]
        ],
    ];

    public function initialize(array $config) {
        $formField = $this->_config['formField'];
        $formFieldRepeat = $this->_config['formFieldRepeat'];
        $formFieldCurrent = $this->_config['formFieldCurrent'];

        if ($formField === $this->_config['field']) {
            throw new Exception('Invalid setup - the form field must to be different from the model field (' . $this->_config['field'] . ').');
        }

        $rules = $this->_validationRules;
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $key => $rule) {
                //$rule['allowEmpty'] = !$this->_config['require'];

                if ($key === 'between') {
                    $rule['rule'][1] = $this->_config['minLength'];
                    $rule['message'][1] = $this->_config['minLength'];
                    $rule['rule'][2] = $this->_config['maxLength'];
                    $rule['message'][2] = $this->_config['maxLength'];
                }

                if (is_array($rule['message'])) {
                    $message = array_shift($rule['message']);
                    $rule['message'] = __d('passengers', $message, $rule['message']);
                } else {
                    $rule['message'] = __d('passengers', $rule['message']);
                }
                $fieldRules[$key] = $rule;
            }
            $rules[$field] = $fieldRules;
        }

        $validator = $this->_table->validator($this->_config['validator']);

        // Add the validation rules if not already attached
        if (!count($validator->field($formField))) {
            $validator->add($formField, $rules['formField']);
            $validator->allowEmpty($formField, !$this->_config['require'], __d('passengers', 'Password field should not empty'));
        }
        if (!count($validator->field($formFieldRepeat))) {
            $ruleSet = $rules['formFieldRepeat'];
            $ruleSet['validateIdentical']['rule'][1] = $formField;
            $validator->add($formFieldRepeat, $ruleSet);
            $require = $this->_config['require'];
            $validator->allowEmpty($formFieldRepeat, function ($context) use ($require, $formField) {
                if (!$require && !empty($context['data'][$formField])) {
                    return false;
                }
                return !$require;
            }, __d('passengers', 'Password confirmation field should not empty'));
        }

        if ($this->_config['current'] && !count($validator->field($formFieldCurrent))) {
            $validator->add($formFieldCurrent, $rules['formFieldCurrent']);
            $validator->allowEmpty($formFieldCurrent, !$this->_config['require'], __d('passengers', 'Current password field should not empty'));

            if (!$this->_config['allowSame']) {
                $validator->add($formField, 'validateNotSame', [
                    'rule' => ['validateNotSame', ['compare' => $formFieldCurrent]],
                    'message' => __d('tools', 'valErrPwdSameAsBefore'),
                    'last' => true,
                    'provider' => 'table'
                ]);
            }
        } elseif (!count($validator->field($formFieldCurrent))) {
            // Try to match the password against the hash in the DB
            if (!$this->_config['allowSame']) {
                $validator->add($formField, 'validateNotSame', [
                    'rule' => ['validateNotSameHash'],
                    'message' => __d('tools', 'valErrPwdSameAsBefore'),
                    //'allowEmpty' => !$this->_config['require'],
                    'last' => true,
                    'provider' => 'table'
                ]);
                $validator->allowEmpty($formField, !$this->_config['require'], __d('passengers', 'Current password field should not empty'));
            }
        }

        // Add custom rule(s) if configured
        if ($this->_config['customValidation']) {
            $validator->add($formField, $this->_config['customValidation']);
        }
    }

}
