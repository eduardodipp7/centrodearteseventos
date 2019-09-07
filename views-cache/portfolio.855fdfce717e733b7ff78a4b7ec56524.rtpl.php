<?php if(!class_exists('Rain\Tpl')){exit;}?>  <header class="pagina-cabecalho">
            <?php $counter1=-1;  if( isset($port) && ( is_array($port) || $port instanceof Traversable ) && sizeof($port) ) foreach( $port as $key1 => $value1 ){ $counter1++; ?>
            <h1 class="pagina-cabecalho__titulo anime"><?php echo htmlspecialchars( $value1["destitulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
        </header>
        <section class="pagina-conteudo">
            <div id="servicos__texto">
          <?php echo FormataEditor($value1["destexto"]); ?>
      </div>

            <nav>
                <?php } ?>
                <ul class="lista-trabalhos">
                   <?php $counter1=-1;  if( isset($fotos) && ( is_array($fotos) || $fotos instanceof Traversable ) && sizeof($fotos) ) foreach( $fotos as $key1 => $value1 ){ $counter1++; ?>
                    <li class="lista-trabalhos__item anime">
                        <a data-fancybox="gallery" href="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                            <img class="lista-trabalhos__img" src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="">
                            <h2 class="lista-trabalhos__titulo"><?php echo htmlspecialchars( $value1["desfoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
                        
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </section>

    