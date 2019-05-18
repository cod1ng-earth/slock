<?php

declare(strict_types=1);

namespace App\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class EarthBox extends FunctionNode
{
    private $earth;
    private $radius;

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'earth_box('.$this->earth->dispatch($sqlWalker).', '.$this->radius->dispatch($sqlWalker).')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->earth = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);

        $this->radius = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
