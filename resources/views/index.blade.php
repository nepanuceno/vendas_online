<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @foreach ($compra['produtos'] as $produto)
                <input type="hidden" name='produto_id_{{ $produto['id'] }}' value="{{ $produto['id'] }}">
                <p><strong>{{ $produto['descricao'] }}</strong> - <span>R$ {{ $produto['valor'] }}</span></p>
                <p><label>Quantidade: {{ $produto['quantidade'] }}</label></p>
                @if ($produto['estoque'] < 3)
                    @if ($produto['estoque'] < 2)
                        <p>Último item no estoque.</p>
                    @else
                        <p>Apenas {{ $produto['estoque'] }} itens no estoque.</p>
                    @endif
                @endif
                <hr>
            @endforeach
            <label>Cupom de Desconto:</label>
            <span><strong>{{ $compra['cupom_desconto'] }}</strong></span>
            <hr>
            <h3>VALOR TOTAL: R$ {{ $compra['valor_total'] }}</h3>
    </div>
    <h3>Frete: R$ {{ $compra['valor_frete'] }}</h3>
    <h2>VALOR FINAL: R$ {{ $compra['valor_final'] }}</h2>
    <ul>
    @foreach ($produtos as $produto)
        <li>{{ $produto['estoque'] }} {{ $produto['descricao'] }} em Estoque</li>
    @endforeach
    </ul>
</body>

</html>
