<?php if(!class_exists('Rain\Tpl')){exit;}?> <article>
             <?php $counter1=-1;  if( isset($sobre) && ( is_array($sobre) || $sobre instanceof Traversable ) && sizeof($sobre) ) foreach( $sobre as $key1 => $value1 ){ $counter1++; ?>
            <header class="pagina-cabecalho">
                <h1 class="pagina-cabecalho__titulo anime"><?php echo htmlspecialchars( $value1["destitulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
            </header>
            <section class="container pagina-conteudo">
                <h2 class="text-center"></h2>
                <img src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="img-left-md">
                  <div id="servicos__texto">
                <?php echo FormataEditor($value1["destexto"]); ?>
            </div>
            </section>
            <?php } ?>
        </article>