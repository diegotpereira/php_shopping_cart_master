CREATE TABLE `produtos` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
 `descricao` text COLLATE utf8_unicode_ci NOT NULL,
 `preco` float(10,2) NOT NULL,
 `criado` datetime NOT NULL,
 `modified` datetime NOT NULL,
 `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `clientes` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `nome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
 `sobrenome` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
 `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 `telefone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
 `endereco` text COLLATE utf8_unicode_ci NOT NULL,
 `criado` datetime NOT NULL,
 `modificado` datetime NOT NULL,
 `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `pedidos` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `cliente_id` int(11) NOT NULL,
 `total_geral` float(10,2) NOT NULL,
 `criado` datetime NOT NULL,
 `status` enum('Pendente','Concluida','Cancelada') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pendente',
 PRIMARY KEY (`id`),
 KEY `cliente_id` (`cliente_id`),
 CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `pedido_itens` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `pedido_id` int(11) NOT NULL,
 `produto_id` int(11) NOT NULL,
 `quantidade` int(5) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `pedido_id` (`pedido_id`),
 CONSTRAINT `pedidos_itens_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;