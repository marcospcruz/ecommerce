drop procedure if exists limpa_temp_cart;
DELIMITER $$
CREATE PROCEDURE LIMPA_TEMP_CART()
BEGIN
	
	declare LIMITE_TEMPO int;
	/**
	  * Declarando as variáveis que representarão os valores das colunas trazidas pelo cursor.
	  **/
	declare idEstoque,idCarrinhoTemp int;	
	declare quantidade decimal;

	/**
	  * declarando cursor para receber a consulta em carrinho_temp relacionada ao estoqueProduto
	  **/
	declare _cursor cursor for select  C.idEstoqueProduto,C.idCompraTemp,ep.quantidade from carrinho_temp C inner join estoqueProduto ep on ep.idEstoqueProduto=C.idEstoqueProduto where timestampdiff(minute,C.datahoracompra,now())>LIMITE_TEMPO;

	/**
	  * Limite de tempo em MINUTOS que os itens de compras estarão reservados.
	  **/
	set LIMITE_TEMPO=60;

	/**
	  * Fazendo a consulta às tabelas relacionadas.
	  **/
	open _cursor;

	/**
	  * Iterando os valores do cursor
	  **/
	MYloop: loop
		/**
		  * Atribuindo os valores trazidos pelo cursor.
		  **/
		fetch _cursor into idEstoque,idCarrinhoTemp,quantidade;
		/**
		  * Incrementando a quantidade do produto ou devolvendo o item ao estoque.
		  **/
		set quantidade =quantidade+1.0;
		
		update estoqueProduto set quantidade=quantidade where idEstoqueProduto=idEstoque;
		delete from carrinho_temp where idCompraTemp=idCarrinhoTemp;

	end loop MYloop;
	close _cursor;

END $$
DELIMITER ;



/**
  * CRIANDO JOB
  * show processlist
  **/
--
SET GLOBAL event_scheduler = ON;

grant event on xtreme_sote.* to root@localhost;

drop  event if exists LIMPA_TEMP_CART_JOB;

CREATE EVENT LIMPA_TEMP_CART_JOB
    ON SCHEDULE
      EVERY 5 MINUTE
    DO
      CALL LIMPA_TEMP_CART;

/**
  * SELECT event_schema,event_name,interval_value,interval_field,definer,event_definition,EVENT_TYPE,last_executed  FROM
  * INFORMATION_SCHEMA.EVENTS;
  **/
