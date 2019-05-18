<?php

declare(strict_types=1);

namespace App\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class LLToEarth extends FunctionNode
{
    private $latitude;
    private $longitude;

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'll_to_earth('.$this->latitude->dispatch($sqlWalker).', '.$this->longitude->dispatch($sqlWalker).')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->latitude = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);

        $this->longitude = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
