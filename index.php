<?php
echo "       **Mercadinho JWT**        ";// apenas indicando o nome do mercadinho para iniciar o projeto

class Produto { //criando  a classe Produto com os atibutos nome, preço e quantidade.
    public $nome;
    public $preco;
    public $quantidade;
               
    public function __construct($data){ //usando o metodo construtor
        $this->setProduto($data); 
    }
    public function setProduto($data) // criando o metodo setProduto para cadastrar os produtos.
    { 
        $produtoEmEstoque = false;   // adicionando uma variável para auxiliar no controle de erro caso o estoque seja insuficiente
        if ((is_array($data)) && ($this->nome == $data["nome"])){
          $produtoEmEstoque = true;
          $this->nome = $data['nome'];
          $this->preco = $data['preco'];
          $this->quantidade = $data['quantidade'];
          echo "\n= = = = = = = = = = = = = = = = = \nProduto atualizado: \nnome: {$this->nome} \npreço: {$this->preco} \nquantidade: {$this->quantidade}";
        }
        //cadastrando o produto caso não exista no estoque e retornando uma mensagem para confirmar
        if (!$produtoEmEstoque){
            $this->nome = $data["nome"];
            $this->preco = $data["preco"];
            $this->quantidade = $data["quantidade"];
        echo "\n= = = = = = = = = = = = = = = = = \nSucesso, produto cadastrado: \nnome: {$this->nome} \npreço: {$this->preco} \nquantidade: {$this->quantidade}";
        } else {
            echo "\n= = = = = = = = = = = = = = = = = O parâmetro data deve ser um array";
          }
    }
    public function getProduto() // criando o método getProduto que apenas é responsável por exibir algum produto cadastrado.
    {
        return array('nome'=> $this->nome,'preço' => $this->preco, 'quantidade'=> $this->quantidade);
    }
};

class Venda extends Produto {//criando a classe venda
  private $quantidadeVendida;
  private $desconto;
  //usando o metodo construtor
  public function __construct($nome, $quantidadeVendida, $desconto) { //usando metodo construtor
    $produto = $this->getProduto();
    // Chama o metodo construtor da classe Produto que é a classe pai
    parent::__construct($produto);
    $this->quantidadeVendida = $quantidadeVendida;
    $this->desconto = $desconto;
  }
  // criando o setVenda
  public function setVenda() {
    $produto = $this->getProduto();
    if ($produto) {    // vendo se o produto existe
      if ($produto['quantidade'] >= $this->quantidadeVendida) {// vendo se o estoque é suficiente
        $valor_total = ($produto['preco'] * $this->quantidadeVendida) * (1 - $this->desconto / 100);//usando uma variael de apoio para ter o valor total da venda
        $produto['quantidade'] -= $this->quantidadeVendida; // atualizado a quantidade de produto no estoque
        echo "\n= = = = = = = = = = = = = = = = = \nVenda realizada com sucesso.";//retornando uma mensagem de sucesso caso estea tudo ok
        $this->getVenda($valor_total, $produto['quantidade']);//usando o metodo getvenda para mostrar a ultima venda
      } else {
        echo "\n= = = = = = = = = = = = = = = = = \nEstoque insuficiente";//retornando uma mensagem de estoque inuficiente
      }
    } else {
      echo "\n= = = = = = = = = = = = = = = = = \nProduto não cadastrado.";//mensagem de produto nao cadastrado caso necessario
    }
  }
  public function getVenda($valorTotal, $estoqueAtual) { // Criando o getVenda para retornar a ultima venda feita.
    $produto = $this->getProduto();   
    echo "Produto: {$produto['nome']}";
    echo "Preço: R$ {$produto['preco']}";
    echo "Quantidade vendida: {$this->quantidadeVendida}";
    echo "Desconto: {$this->desconto}%";
    echo "Valor total: R$ {$valorTotal}";
    echo "Estoque atual: {$estoqueAtual}";
  }
}
