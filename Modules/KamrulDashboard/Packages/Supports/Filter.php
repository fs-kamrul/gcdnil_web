<?php

namespace Modules\KamrulDashboard\Packages\Supports;

class Filter extends ActionHookEvent
{

    /**
     * Filters a value
     * @param string $action Name of filter
     * @param array $args Arguments passed to the filter
     * @return string Always returns the value
     */
    public function fire($action, $args)
    {
        $value = isset($args[0]) ? $args[0] : ''; // get the value, the first argument is always the value
        if (!$this->getListeners()) {
            return $value;
        }

//        dd($action);
//        dd($this->getListeners());
        foreach ($this->getListeners() as $hook => $listeners) { // go through each of the priorities
//            dd($hook);
//            dd($action);
            ksort($listeners);
//            if($hook == 'group_public_route') {    dd($arguments); }
            foreach ($listeners as $arguments) { // loop all hooks
                if ($hook === $action) { // if the hook responds to the current filter
//                    dd($action);
                    $parameters = [$value];
                    for ($index = 1; $index < $arguments['arguments']; $index++) {
                        if (isset($args[$index])) {
                            $parameters[] = $args[$index]; // add arguments if it is there
                        }
                    }
                    // filter the value
                    $value = call_user_func_array($this->getFunction($arguments['callback']), $parameters);
                }
            }
        }
        return $value;
    }
}
