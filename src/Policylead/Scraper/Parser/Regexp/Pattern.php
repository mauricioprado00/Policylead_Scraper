<?php

namespace Policylead\Scraper\Parser\Regexp;

/**
 * Class Pattern
 * @package Policylead\Scraper\Parser\Regexp
 * 
 * allows you to use patterns based only on definitions
 */
class Pattern
{
    /**
     * @var string $definitions
     */
    private $definitions = '';

    /**
     * @var array $pattern
     */
    private $pattern = [];

    /**
     * @var bool $beginsWith
     */
    private $beginsWith = false;
    
    /**
     * @param string $definitions
     * @return $this
     */
    public function setDefinitions($definitions)
    {
        $this->definitions = $definitions;
        return $this;
    }

    /**
     * @param string $definitions
     * @return $this
     */
    public function addDefinitions($definitions)
    {
        $this->definitions .= $definitions;
        return $this;
    }

    /**
     * @param array $pattern
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @param boolean $beginsWith
     * @return $this
     */
    public function setBeginsWith($beginsWith)
    {
        $this->beginsWith = $beginsWith ? true : false;
        return $this;
    }

    /**
     * @return string
     */
    public function buildRegexp()
    {
        $pattern = '';
        foreach ($this->pattern as $key => $entity) {
            $any_space = '(?&any_space)';
            if (is_array($entity)) {
                $any_space = !isset($entity['spaces_after']) || $entity['spaces_after'] ? $any_space : '';
                $entity = $entity['name'];
            }
            
            if (is_numeric($key)) {
                $pattern .= <<< PAT
(?&{$entity}) $any_space

PAT;
            } else {
                $pattern .= <<< PAT
(?<{$key}>(?&{$entity})) $any_space

PAT;
            }
        }
        
        if ($this->beginsWith) {
            $pattern = '^' . $pattern;
        }

        return "/ (?(DEFINE){$this->definitions}) {$pattern} /six";
    }

    /**
     * @param $content
     * @return bool
     */
    public final function test($subject)
    {
        return preg_match($this->buildRegexp(), $subject) ? true : false;
    }

    /**
     * @param $subject
     * @param array|null $matches
     * @param int $flags
     * @param int $offset
     * @return int
     */
    public final function match($subject, array &$matches = null, $flags = 0, $offset = 0)
    {
        return preg_match($this->buildRegexp(), $subject, $matches, $flags, $offset);
    }

    /**
     * @param $subject
     * @param array|null $matches
     * @param int $flags
     * @param int $offset
     * @return int
     */
    public final function match_all($subject, array &$matches = null, $flags = PREG_PATTERN_ORDER, $offset = 0)
    {
        return preg_match_all($this->buildRegexp(), $subject, $matches, $flags, $offset);
    }

    /**
     * @param $capture_name
     * @param $subject
     * @param array|null $matches
     * @param int $flags
     * @param int $offset
     * @return mixed
     */
    public final function match_all_get($capture_name, $subject, array &$matches = null, $flags = PREG_PATTERN_ORDER, $offset = 0)
    {
        $res = $this->match_all($subject, $matches, $flags, $offset);
        if ($res && isset($matches[$capture_name])) {
            return $matches[$capture_name];
        }
    }
}
