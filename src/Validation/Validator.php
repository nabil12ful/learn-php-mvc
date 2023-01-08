<?php
namespace Nopel\Validation;

use Nopel\Validation\Rules\Contract\Rule;

class Validator
{
    use RulesResolver;
    protected array $data = [];

    protected array $aliases = [];

    protected array $rules = [];

    

    protected ErrorBag $errorBag;

    /**
     * Make validate
     *
     * @param array $data
     * @param array $rules
     **/
    public function make(array $data, array $rules, array $aliases = null)
    {
        $this->data = $data;

        if(!is_null($aliases))
        {
            $this->setAliases($aliases);
        }

        $this->setRule($rules);

        $this->errorBag = new ErrorBag;

        $this->validate();
    }

    protected function validate()
    {

        foreach($this->rules as $field => $rules)
        {

            foreach($this->resolveRules($rules) as $rule)
            {

                $this->applyRule($field, $rule);

            }

        }

    }


    protected function applyRule($field, Rule $rule)
    {
        // if(is_string($rule))
        // {
        //     $rule = new $this->ruleMap[$rule];
        // }

        if(!$rule->apply($field, $this->getFieldValue($field), $this->data))
        {
            $this->errorBag->add($field, Message::generate($rule, $this->alias($field)));
        }
    }

    public function getFieldValue($field)
    {
        return $this->data[$field] ?? null;
    }

    function setRule($rules)
    {
        $this->rules = $rules;
    }

    public function passes()
    {
        return empty($this->errors());
    }

    public function errors($key = null)
    {
        return $key ? $this->errorBag->errors[$key] : $this->errorBag->errors;
    }

    public function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }

    public function setAliases($aliases)
    {
        $this->aliases = $aliases;
    }
}