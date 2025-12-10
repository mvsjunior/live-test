<?php

declare(strict_types=1);

namespace App\Actions;

class ProcessCpfAction
{
    /**
     * Entrada: string com CPFs separados por vírgula.
     * Saída: array de CPFs processados.
     */
    public function handle(string $strCpfList): array
    {
        $list = $this->buildCpfList($strCpfList);

        if (count($list) === 0) {
            return [];
        }

        $sanitized = [];
        foreach ($list as $cpf) {
            $clean = $this->sanitizeCpfInput((string) $cpf);
            $padded = $this->leftPadToLength($clean, 11, '0');
            $sanitized[] = $padded;
        }

        // Remove primeiro dígito do primeiro e do último CPF (se for o mesmo índice, apenas uma vez)
        $firstIndex = 0;
        $lastIndex = count($sanitized) - 1;

        if ($firstIndex === $lastIndex) {
            // apenas um CPF na lista
            $sanitized[$firstIndex] = $this->removeFirstChar($sanitized[$firstIndex]);
        } else {
            $sanitized[$firstIndex] = $this->removeFirstChar($sanitized[$firstIndex]);
            $sanitized[$lastIndex] = $this->removeFirstChar($sanitized[$lastIndex]);
        }

        return $sanitized;
    }

    /**
     * Constrói lista de CPFs separando por vírgula.
     */
    private function buildCpfList(string $cpfList = ''): array
    {
        return $this->customExplode(',', $cpfList);
    }

    /**
     * Impl. simples de explode sem usar funções nativas de string proibidas.
     * Retorna array vazio se a string estiver vazia ou contiver apenas espaços.
     */
    private function customExplode(string $delimiter, string $string): array
    {
        // trim manual (remover espaços no início/fim) - impl. simples
        $string = $this->trimManual($string);

        if ($this->customStrLen($string) === 0) {
            return [];
        }

        $result = [];
        $current = '';

        $dLen = $this->customStrLen($delimiter);
        $sLen = $this->customStrLen($string);

        for ($i = 0; $i < $sLen; $i++) {
            $isDelimiter = false;

            // verifica se o delimitador cabe e bate aqui
            if ($dLen > 0) {
                $matches = true;
                for ($j = 0; $j < $dLen; $j++) {
                    if (!isset($string[$i + $j]) || $string[$i + $j] !== $delimiter[$j]) {
                        $matches = false;
                        break;
                    }
                }
                if ($matches) {
                    $isDelimiter = true;
                }
            }

            if ($isDelimiter) {
                $trimmed = $this->trimManual($current);
                $result[] = $trimmed;
                $current = '';
                // pular o delimitador
                $i += $dLen - 1;
            } else {
                $current .= $string[$i];
            }
        }

        // último pedaço
        $last = $this->trimManual($current);
        $result[] = $last;

        return $result;
    }

    /**
     * Mantém apenas os dígitos do CPF de entrada.
     */
    private function sanitizeCpfInput(string $cpf): string
    {
        $out = '';
        $len = $this->customStrLen($cpf);
        for ($i = 0; $i < $len; $i++) {
            $char = $cpf[$i];
            if ($this->isDigit($char)) {
                $out .= $char;
            }
        }
        return $out;
    }

    /**
     * Left pad manual até atingir $length com o caractere $padChar.
     */
    private function leftPadToLength(string $str, int $length, string $padChar = '0'): string
    {
        $currentLen = $this->customStrLen($str);
        while ($currentLen < $length) {
            $str = $padChar . $str;
            $currentLen++;
        }
        return $str;
    }

    /**
     * Remove o primeiro caractere de uma string sem usar substr/mb_substr.
     * Se string vazia, retorna vazia.
     */
    private function removeFirstChar(string $str): string
    {
        $len = $this->customStrLen($str);
        if ($len === 0) {
            return $str;
        }

        $out = '';
        for ($i = 1; $i < $len; $i++) {
            $out .= $str[$i];
        }

        return $out;
    }

    /**
     * Retorna quantos caracteres existem em $str sem usar strlen.
     */
    private function customStrLen(string $str): int
    {
        $i = 0;
        while (isset($str[$i])) {
            $i++;
        }
        return $i;
    }

    /**
     * Verifica se um caractere é dígito '0'..'9' comparando diretamente.
     */
    private function isDigit(string $char): bool
    {
        // espera 1 caractere; se for vazio, retorna false
        if ($this->customStrLen($char) === 0) {
            return false;
        }

        $c = $char[0];
        return ($c >= '0' && $c <= '9');
    }

    /**
     * Trim manual: remove espaços no início e fim.
     */
    private function trimManual(string $str): string
    {
        $start = 0;
        $len = $this->customStrLen($str);
        // achar início não-space
        while ($start < $len && $str[$start] === ' ') {
            $start++;
        }

        // achar fim não-space
        $end = $len - 1;
        while ($end >= $start && $str[$end] === ' ') {
            $end--;
        }

        if ($start === 0 && $end === $len - 1) {
            return $str; // já trimada
        }

        $out = '';
        for ($i = $start; $i <= $end; $i++) {
            $out .= $str[$i];
        }

        return $out;
    }
}
