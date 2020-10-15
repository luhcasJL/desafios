<?php //$this->load->view('elements/header');?>
<?php //$this->load->view('elements/sidebar');?>
<!--
Desafio jogo caça palavras. (Feito entre conhecidos em grupo de WPP)

Entrega: 15/10 até as 23h, postar o link aqui apenas no dia para não atrapalhar o raciocínio de quem já está fazendo

Regras:
- inserção de 10 palavras
- o espaço deve ter 20 colunas e 24 linhas
- as palavras incluídas devem ser impressas em vermelho
- qualquer linguagem de programação
- o código deve ser postado no github
- o projeto deve ser gravado funcionando utilizando OBS Studio ou similar
- as letras de ocupação devem ser aleatórias todas as vezes, mesmo quando as palavras inseridas foram iguais
- possibilidade de preencher em todas as direções
-->

<!-- Meus comentários -->
<!-- Apesar de programar via orientação a objetos usando mvc e preferencialmente usando o framework codeigniter;
decide para este desafio usar arquivo único de forma que iniciantes na programação também consigam perceber a lógica
empregada na resolução do problema -->

<style media="screen">
  body{
    margin: 1% 5%;
    padding: 0;
  }
  td{
    padding: 0.5%;
  }
  .div_caca_palavras{
    margin-top: -25px;
    display: flex;
    justify-content: center;
  }
</style>
<div class="p-5">
  <?php
  $matriz = [];
  $orientacao = [
    '0' => 'vertical_normal',
    '1' => 'vertical_invertido',
    '2' => 'horizontal_normal',
    '3' => 'horizontal_invertido',
    '4' => 'diagonal_nordeste',
    '5' => 'diagonal_sudeste',
    '6' => 'diagonal_sudoeste',
    '7' => 'diagonal_noroeste',
   ];
  $cel = 0;
  for ($i=0; $i <= 23; $i++) {
      // ($cel==480)? break :''; // aparentemente não pode ser assim
      if ($cel==480){ break; }
      $linha = [
        $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '',
        $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '',
        $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '',
        $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '', $cel++ => '',
      ];

      array_push($matriz, $linha);
  }

  $arr_palavras = [
    0 => [
      'MESA', 'IMPRESSORA', 'LATARIA', 'LIVRO', 'JARDIM',
      'PREDIO', 'FLOR', 'MEL', 'BATATA', 'AGUA'
    ],
    1 => [
      'CASA', 'COMPUTADOR', 'MONITOR', 'MOUSE', 'CARREGADOR',
      'LUZ', 'FOLHA', 'PORTA', 'CAQUI', 'ALHO'
    ],
    2 => [
      'ABELHA', 'BEZERRO', 'BORBOLETA', 'CABRA', 'DINOSSAURO',
      'ESMERILHAO', 'FOCA', 'GAROUPA', 'HIENA', 'JIBOIA'
    ],
    3 => [
      'ALEMANHA', 'BELGICA', 'CHIPRE', 'DINAMARCA', 'MALTA',
      'NORUEGA', 'MONACO', 'GRECIA', 'SERVIA', 'SUECIA'
    ],
    4 => [
      'ACEROLA', 'CAJU', 'CHERIMOIA', 'GRAVIOLA', 'JUJUBA',
      'MANGA', 'MORANGO', 'PINHA', 'PITAYA', 'TAMARINDO'
    ]
  ];

  $key_palavras = array_rand($arr_palavras, 1);
  $palavras = $arr_palavras[$key_palavras];

  foreach ($palavras as $key => $value) {
    $array_palavra = str_split($value);
    $tamanho_palavra = strlen($value);

    $giro = 0;
    while ($giro == 0) {
      $erro = 0;
      $forma_impressao = array_rand($orientacao, 1);
      // $forma_impressao = 7;
      $rand_keys = array_rand($matriz, 1);
      $celula_inicial = array_rand($matriz[$rand_keys], 1);
      $primeira_celula_linha = array_key_first($matriz[$rand_keys]);
      $ultima_celula_linha = array_key_last($matriz[$rand_keys]);

      if ($forma_impressao == 0) {
        if(23 < ($rand_keys + $tamanho_palavra)){
          // echo "não pode imprimir ai";
          continue;
        }else{
          // echo "talvez possa imprimir aqui";
          $natural = array();
          foreach ($array_palavra as $key => $value) {
            if ($matriz[$rand_keys][$celula_inicial] == '') {
              $matriz[$rand_keys][$celula_inicial] = $value;
              array_push($natural, '');
            }else{
              if ($matriz[$rand_keys][$celula_inicial] == $value) {
                array_push($natural, $value);
              }else{
                $erro = 1;
                break;
              }
            }
            $rand_keys++;
            $celula_inicial = $celula_inicial + 20;
          }
          if ($erro == 0) {
            $giro = 1;
          }else{
            $rand_keys--;
            $celula_inicial = $celula_inicial - 20;

            $volta = array_reverse($natural);
            foreach ($volta as $key => $value) {
              $matriz[$rand_keys][$celula_inicial] = $value;
              $rand_keys--;
              $celula_inicial = $celula_inicial - 20;
            }
          }
        }
      }else if ($forma_impressao == 1) {
          if(($rand_keys - $tamanho_palavra) < 0){
            // echo "não pode imprimir ai";
            continue;
          }else{
            // echo "talvez possa imprimir aqui"; die;
            $natural = array();
            foreach ($array_palavra as $key => $value) {
              if ($matriz[$rand_keys][$celula_inicial] == '') {
                $matriz[$rand_keys][$celula_inicial] = $value;
                array_push($natural, '');
              }else{
                if ($matriz[$rand_keys][$celula_inicial] == $value) {
                  array_push($natural, $value);
                }else{
                  $erro = 1;
                  break;
                }
              }
              $rand_keys--;
              $celula_inicial = $celula_inicial - 20;
            }
            if ($erro == 0) {
              $giro = 1;
            }else{
              $rand_keys++;
              $celula_inicial = $celula_inicial + 20;

              $volta = array_reverse($natural);
              foreach ($volta as $key => $value) {
                $matriz[$rand_keys][$celula_inicial] = $value;
                $rand_keys++;
                $celula_inicial = $celula_inicial + 20;
              }
            }
          }
      }else if ($forma_impressao == 2) {
          if($ultima_celula_linha < ($celula_inicial + $tamanho_palavra)){
            // echo "não pode imprimir ai";
            continue;
          }else{
            // echo "talvez possa imprimir aqui"; die;
            $natural = array();
            foreach ($array_palavra as $key => $value) {
              if ($matriz[$rand_keys][$celula_inicial] == '') {
                $matriz[$rand_keys][$celula_inicial] = $value;
                array_push($natural, '');
              }else{
                if ($matriz[$rand_keys][$celula_inicial] == $value) {
                  array_push($natural, $value);
                }else{
                  $erro = 1;
                  break;
                }
              }
              $celula_inicial++;
            }
            if ($erro == 0) {
              $giro = 1;
            }else{
              $celula_inicial--;

              $volta = array_reverse($natural);
              foreach ($volta as $key => $value) {
                $matriz[$rand_keys][$celula_inicial] = $value;
                $celula_inicial--;
              }
            }
          }
      }else if ($forma_impressao == 3) {
        if($primeira_celula_linha > ($celula_inicial - $tamanho_palavra)){
          // echo "não pode imprimir ai";
          continue;
        }else{
          // echo "talvez possa imprimir aqui";
          $natural = array();
          foreach ($array_palavra as $key => $value) {
            if ($matriz[$rand_keys][$celula_inicial] == '') {
              $matriz[$rand_keys][$celula_inicial] = $value;
              array_push($natural, '');
            }else{
              if ($matriz[$rand_keys][$celula_inicial] == $value) {
                array_push($natural, $value);
              }else{
                $erro = 1;
                break;
              }
            }
            $celula_inicial--;
          }
          if ($erro == 0) {
            $giro = 1;
          }else{
            $celula_inicial++;

            $volta = array_reverse($natural);
            foreach ($volta as $key => $value) {
              $matriz[$rand_keys][$celula_inicial] = $value;
              $celula_inicial++;
            }
          }
        }
      }else if ($forma_impressao == 4) {
        if((($rand_keys - $tamanho_palavra) < 0) || ($ultima_celula_linha < ($celula_inicial + $tamanho_palavra))){
          // echo "não pode imprimir ai";
          continue;
        }else{
          // echo "talvez possa imprimir aqui";
          $natural = array();
          foreach ($array_palavra as $key => $value) {
            if ($matriz[$rand_keys][$celula_inicial] == '') {
              $matriz[$rand_keys][$celula_inicial] = $value;
              array_push($natural, '');
            }else{
              if ($matriz[$rand_keys][$celula_inicial] == $value) {
                array_push($natural, $value);
              }else{
                $erro = 1;
                break;
              }
            }
            $rand_keys--;
            $celula_inicial = $celula_inicial - 19;
          }
          if ($erro == 0) {
            $giro = 1;
          }else{
            $rand_keys++;
            $celula_inicial = $celula_inicial + 19;

            $volta = array_reverse($natural);
            foreach ($volta as $key => $value) {
              $matriz[$rand_keys][$celula_inicial] = $value;
              $rand_keys++;
              $celula_inicial = $celula_inicial + 19;
            }
          }
        }
      }else if ($forma_impressao == 5) {
        if((23 < ($rand_keys + $tamanho_palavra)) || ($ultima_celula_linha < ($celula_inicial + $tamanho_palavra))){
          // echo "não pode imprimir ai";
          continue;
        }else{
          // echo "talvez possa imprimir aqui"; die;
          $natural = array();
          foreach ($array_palavra as $key => $value) {
            if ($matriz[$rand_keys][$celula_inicial] == '') {
              $matriz[$rand_keys][$celula_inicial] = $value;
              array_push($natural, '');
            }else{
              if ($matriz[$rand_keys][$celula_inicial] == $value) {
                array_push($natural, $value);
              }else{
                $erro = 1;
                break;
              }
            }
            $rand_keys++;
            $celula_inicial = $celula_inicial + 21;
          }
          if ($erro == 0) {
            $giro = 1;
          }else{
            $rand_keys--;
            $celula_inicial = $celula_inicial - 21;

            $volta = array_reverse($natural);
            foreach ($volta as $key => $value) {
              $matriz[$rand_keys][$celula_inicial] = $value;
              $rand_keys--;
              $celula_inicial = $celula_inicial - 21;
            }
          }
        }
      }else if ($forma_impressao == 6) {
        if((23 < ($rand_keys + $tamanho_palavra)) || ($primeira_celula_linha > ($celula_inicial - $tamanho_palavra))){
          // echo "não pode imprimir ai";
          continue;
        }else{
          // echo "talvez possa imprimir aqui"; die;
          $natural = array();
          foreach ($array_palavra as $key => $value) {
            if ($matriz[$rand_keys][$celula_inicial] == '') {
              $matriz[$rand_keys][$celula_inicial] = $value;
              array_push($natural, '');
            }else{
              if ($matriz[$rand_keys][$celula_inicial] == $value) {
                array_push($natural, $value);
              }else{
                $erro = 1;
                break;
              }
            }
            $rand_keys++;
            $celula_inicial = $celula_inicial + 19;
          }
          if ($erro == 0) {
            $giro = 1;
          }else{
            $rand_keys--;
            $celula_inicial = $celula_inicial - 19;

            $volta = array_reverse($natural);
            foreach ($volta as $key => $value) {
              $matriz[$rand_keys][$celula_inicial] = $value;
              $rand_keys--;
              $celula_inicial = $celula_inicial - 19;
            }
          }
        }
      }else if ($forma_impressao == 7) {
        if(($primeira_celula_linha > ($celula_inicial - $tamanho_palavra)) || (($rand_keys - $tamanho_palavra) < 0)){
          // echo "não pode imprimir ai";
          continue;
        }else{
          // echo "talvez possa imprimir aqui"; die;
          $natural = array();
          foreach ($array_palavra as $key => $value) {
            if ($matriz[$rand_keys][$celula_inicial] == '') {
              $matriz[$rand_keys][$celula_inicial] = $value;
              array_push($natural, '');
            }else{
              if ($matriz[$rand_keys][$celula_inicial] == $value) {
                array_push($natural, $value);
              }else{
                $erro = 1;
                break;
              }
            }
            $rand_keys--;
            $celula_inicial = $celula_inicial - 21;
          }
          if ($erro == 0) {
            $giro = 1;
          }else{
            $rand_keys++;
            $celula_inicial = $celula_inicial + 21;

            $volta = array_reverse($natural);
            foreach ($volta as $key => $value) {
              $matriz[$rand_keys][$celula_inicial] = $value;
              $rand_keys++;
              $celula_inicial = $celula_inicial + 21;
            }
          }
        }
      }
    }
  }
 ?>

 <div class="palavras" style="margin-bottom: 50px;">
   <h1 class="text-center">Caça palavras</h1>
   <?php $cont = 0; ?>
   <?php foreach ($palavras as $key => $value): ?>
     <label for="">Palavra <?php echo ++$cont; ?></label>
     <input type="text" name="palavra[]" maxlength="20" value="<?php echo $value ?>">
     <?php echo ($cont == 5)? '<br><br>' : ''?>
   <?php endforeach; ?>
 </div>

 <div class="div_caca_palavras">
   <table style="border: 1px solid #000; width: 50%;">
     <?php $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; ?>
     <?php foreach ($matriz as $key => $value): ?>
       <tr>
         <?php foreach ($value as $key => $value): ?>
           <?php if ($value == ""){ ?>
             <td><?php echo $basic[rand(0, strlen($basic) - 1)]; ?></td>
           <?php }else{ ?>
             <td style="color: red; border: 1px solid #000;"><?php echo $value; ?></td>
           <?php } ?>
         <?php endforeach; ?>
       </tr>
     <?php endforeach; ?>
   </table>
 </div>
</div>

<?php //$this->load->view('elements/footer');?>
