<?php

namespace AndersonDRosa\Mustache;

class Mustache
{
    private $_handler;

    public function handler(\Closure $handler)
    {
        if (!is_callable($handler)) {
            throw new exception("Error Processing Request", 1);
        }

        $this->_handler = $handler;
    }

    public function render($content)
    {
        $p = '# \!{{| \{\{((?: (?:\'[^\']*\') |(?:"[^"]*") |(?: [^}]) )*) \}\} #x';

        $self = $this;

        $fn = $self->_handler;

        return preg_replace_callback($p, function ($m) use ($self, $fn) {
            if (!isset($m[1])) {
                return "{{";
            }
            return $fn($m[1]);
        }, $content);
    }
}
