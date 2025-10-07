SELECT 
            v.id_cliente,
            v.id_vendedor,
            v.id_produto,
            v.qnt_itens,
            v.vlr_total,
            v.data_venda,
            c.nome  nomeCliente,
            p.nm_produto  nomeProduto,
            ve.nm_nome  nomeVendedor
        FROM vendas v
        INNER JOIN tb_clientes c ON v.id_cliente = c.id
        INNER JOIN tb_produto p ON v.id_produto = p.id
        INNER JOIN tb_vendedor ve ON v.id_vendedor = ve.id
        ORDER BY v.data_venda DESC;