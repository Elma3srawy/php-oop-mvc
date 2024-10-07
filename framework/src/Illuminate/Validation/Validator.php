<?php 

namespace Illuminate\Validation;

use Illuminate\Validation\Message;
use Illuminate\Validation\ErrorBag;
use Illuminate\Http\Request\Request;
use Illuminate\Validation\RulesResolver;
use Illuminate\Validation\Rules\Contract\Rule;



class Validator
{
    use RulesMapper;
    protected array $rules;
    protected array $aliases;
    protected Request $request;
    protected ErrorBag $errorBag;


    public function __construct()
    {
        $this->errorBag = new ErrorBag();
        $this->request = new Request;
    }

    public function validate($rules , $aliases = null)
    {
        $this->rules = $rules;
        $this->setAliases($aliases);

        foreach ($this->rules as $field => $rules) {
            foreach (RulesResolver::make($rules) as $rule) {
                $this->applyRule($field, $rule);
            }
        }
    }

    protected function applyRule($field, Rule $rule)
    {
        if (!$rule->apply($field , $this->request)) {
            $this->errorBag->add($field, Message::generate($rule, $this->alias($field)));
        }
    }


    protected function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }

    protected function setAliases(array|null $aliases)
    {
        if(is_array($aliases))
        {
            return $this->aliases =  $aliases;
        }
    }

    public function errors()
    {
        return $this->errorBag->errors;
    }


    public function __destruct()
    {
        if(count($this->errors()) > 0)
        {
            back();
        }
    }

}