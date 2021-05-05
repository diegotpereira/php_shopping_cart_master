<?php

if (!session_id()) {
    # code...
    session_start();
}

class Cart {

     protected $cart_contents = array(); 
     
    public function __construct(){ 
        // get the shopping cart array from the session 
        $this->cart_contents = !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL; 
        if ($this->cart_contents === NULL){ 
            // set some base values 
            $this->cart_contents = array('cart_total' => 0, 'total_items' => 0); 
        } 
    } 

    public function contents(){
        $cart = array_reverse($this->cart_contents);

        unset($cart['total_itens']);
        unset($cart['cart_total']);

        return $cart;
    }
    public function get_item($row_id){
        return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$row_id]))
        ? FALSE 
        : $this->cart_contents[$row_id];
    }
    public function total_items(){
        return $this->cart_contents['total_items'];
    }
    public function total(){
        return $this->cart_contents['cart_total'];
    }
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
                $item['qtd'] = (float) $item['qtd'];

                if ($item['qtd'] == 0) {
                    # code...

                    return FALSE;
                }

                $item['preco'] = (float) $item['preco'];

                $rowid = md5($item['id']);

                $old_qtd = isset($this->cart_contents[$rowid]['qtd']) ? (int) $this->cart_contents[$rowid]['qtd'] : 0;

                $item['rowid'] = $rowid;

                $item ['qtd'] += $old_qtd;

                $this->cart_contents[$rowid] = $item;

                if ($this->save_cart()) {
                    # code...
                } else {
                    # code...
                }
                
            }
            
        }
    }
}
?>