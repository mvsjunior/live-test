# 🚀 Desafio Técnico — Formatação de CPFs (PHP + Vue)

## 🎯 Objetivo

Desenvolver uma aplicação simples que receba uma lista de CPFs em uma única string, normalize os dados, valide a quantidade de caracteres e aplique a máscara correta no formato **000.000.000-00**.

A solução deve ser composta por:

✅ Um **back-end em PHP** responsável por:
- Receber uma string com vários CPFs separados por vírgula.
- Limpar caracteres inválidos de cada CPF.
- Completar com zeros à esquerda se tiver menos de 11 dígitos.
- Aplicar a máscara `000.000.000-00`.
- Retornar todos os CPFs formatados em um JSON array.

✅ Um **front-end em Vue** responsável por:
- Permitir ao usuário digitar os CPFs em um input separados por ponto vírgula.
- Enviar a string para a API PHP via POST.
- Exibir a lista de CPFs formatados retornada pelo back-end.

## 🔎 Exemplo de Entrada e Saída

**Exemplo de entrada enviada para a API (via formulário Vue):**
123.456.789.09; 987.6543.21; 111.4447/7735; 456789123; 222-333-444-56

**Saída esperada (resposta da API em JSON):**

```json
[
  "123.456.789-09",
  "000.098.765-43",
  "001.114.447-73",
  "000.045.678-91",
  "022.233.344-45"
]
```

## ⚠️ Restrições Importantes

- 🚫 **Não pode utilizar funções nativas de manipulação de strings**, como:
  - `str_replace`, `substr`, `strlen`, `str_pad`, `preg_match`, `preg_replace`, etc.
  - Você poderá utilizar uma única vez uma função nativa do PHP.
- 🚫 O Input dos CPFs não pode ter máscara.
- ✅ **Pode utilizar laços de repetição** como `for`, `foreach`, `while`, funções (`isset`) e estruturas condicionais (`if`, `switch`, etc.).
- ✅ Pode utilizar arrays para armazenar e manipular os dados.
