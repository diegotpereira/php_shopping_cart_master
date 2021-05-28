<?php
// Iniciar sessão
if (!session_id()) {
    # code...
    session_start();
}

class Carrinho {

     protected $cart_contents = array(); 
     
    public function __construct(){ 
        // obter o array do carrinho de compras da sessão 
        $this->cart_contents = !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL; 
        if ($this->cart_contents === NULL){ 
            // definir alguns valores base 
            $this->cart_contents = array('cart_total' => 0, 'total_itens' => 0); 
        } 
    } 

    /**
     * Retorna a matriz inteira do carrinho
     * @param bool
     * @return array
     */
    public function contents(){

        // reorganizar o mais recente primeiro  
        $carrinho = array_reverse($this->cart_contents);
        
        // remova-os para que não criem problemas ao mostrar a tabela do carrinho
        unset($carrinho['total_itens']);
        unset($carrinho['cart_total']);

        return $carrinho;
    }

    /**
     * Retorna os detalhes de um item específico do carrinho
     * @param
     * @return array 
     */
    public function get_item($row_id){
        return (in_array($row_id, array('total_itens', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$row_id]))
        ? FALSE 
        : $this->cart_contents[$row_id];
    }

    /**
     * Retorna a contagem total de itens 
     * @return int
     */
    public function total_itens(){
        return $this->cart_contents['total_itens'];
    }
    /**
     * Retorna o preço total
     * @return int
     */
    public function total(){
        return $this->cart_contents['cart_total'];
    }

    /**
     * Insira os itens no carrinho e salve-os na sessão
     * @param array
     * @return bool
     */
    public function insert($item = array()){
        if (!is_array($item) OR count($item) === 0) {
            # code...
            return FALSE;
        }else {
            # code...

            if (!isset($item['id'], $item['nome'], $item['preco'], $item['qtd'])) {
                # code...
                return FALSE;
            } else {
                # code...
                /**
                 * Inserir item
                 */
                // preparar a quantidade
                $item['qtd'] = (float) $item['qtd'];

                if ($item['qtd'] == 0) {
                    # code...

                    return FALSE;
                }

                // prepar o preço
                $item['preco'] = (float) $item['preco'];

                // crie um identificador único para o item que está sendo inserido no carrinho
                $rowid = md5($item['id']);

                //pegue a quantidade se já estiver lá e adicione-a
                $old_qtd = isset($this->cart_contents[$rowid]['qtd']) ? (int) $this->cart_contents[$rowid]['qtd'] : 0;

                // recrie a entrada com identificador único e quantidade atualizada
                $item['rowid'] = $rowid;

                $item ['qtd'] += $old_qtd;

                $this->cart_contents[$rowid] = $item;

                // salvar item do carrinho
                if ($this->save_cart()) {
                    # code...
                    return isset($rowid) ? $rowid : TRUE;
                } else {
                    # code...
                    return FALSE;
                }
                
            }
            
        }
    }
    /**
     * Atualiza o carrinho
     * @param array
     * @return bool
     */
    public function update($item = array()){
        if (!is_array($item) OR count($item) === 0) {
            # code...
            return FALSE;
        } else {
            # code...
            if (!isset($item[`rowid`], $this->cart_contents[$item['rowid']])) {
                # code...
                return FALSE;
            } else {
                # code...
                // prepara a quantidade
                if (isset($item['qtd'])) {
                    # code...
                    $item['qtd'] = (float) $item['qtd'];

                    // remova o item do carrinho, se a quantidade for zero
                    if ($item['qtd'] == 0) {
                        # code...
                        unset($this->cart_contents[$item['rowid']]);

                        return TRUE;
                    }
                }

                // encontrar chaves atualizáveis
                $keys = array_intersect(array_keys($this->cart_contents[$item['rowid']]), array_keys($item));

                if (isset($item['preco'])) {
                    # code...
                    $item['preco'] = (float) $item['preco'];
                }

                // o id e o nome do produto não devem ser alterados
                foreach (array_diff($keys, array('id', 'nome')) as $key) {
                    # code...
                    $this->cart_contents[$item[`rowid`]][$key] = $item[$item];
                }

                // salvar dados do carrinho
                $this->save_cart();
                return TRUE;
            }            
        }
        
    }

    /**
     * Salve a matriz do carrinho para a sessão
     * @return bool
     */
    protected function save_cart(){
        $this->cart_contents['total_itens'] = $this->cart_contents['cart_total'] = 0;

        foreach ($this->cart_contents as $key => $val){

            // certifique-se de que a matriz contém os índices adequados
            if (!is_array($val) OR !isset($val['preco'], $val['qtd'])) {
                # code...
                continue;
            }
            $this->cart_contents['cart_total'] += ($val['preco'] * $val['qtd']);
            $this->cart_contents['total_itens'] += ($val['qtd']);
            $this->cart_contents[$key]['subtotal'] = ($this->cart_contents[$key]['preco']) * $this->cart_contents[$key]['qtd'];
        }

        // se o carrinho estiver vazio, exclua-o da sessão
        if (count($this->cart_contents) <= 2) {
            # code...
            unset($_SESSION['cart_contents']);
            return FALSE;
        } else {
            # code...
            $_SESSION['cart_contents'] = $this->cart_contents;
            return TRUE;
        }
    }

    /**
     * Remove um item do carrinho
     * @param int
     * @return bool
     */
    public function remove($row_id){

        // desmarcar e salvar
        unset($this->cart_contents[$row_id]);
        $this->save_cart();
        return true;
    }

    /**
     * Esvazia o carrinho e destrói a sessão
     * @return void
     */
    public function destroy(){
        $this->cart_contents = array('cart_total' => 0, 'total_itens' => 0);
        unset($_SESSION['cart_contents']);  
    }
}
?>  