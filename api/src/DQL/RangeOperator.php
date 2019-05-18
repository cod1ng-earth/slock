<?php

declare(strict_types=1);

namespace App\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class RangeOperator extends FunctionNode
{
    private $operator;
    private $first;
    private $second;

    /**
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf('%s @> %s',
            $this->first->dispatch($sqlWalker),
            $this->second->dispatch($sqlWalker)
        );
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->first = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);

        $this->second = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
