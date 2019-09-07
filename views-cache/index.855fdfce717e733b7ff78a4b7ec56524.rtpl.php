<?php if(!class_exists('Rain\Tpl')){exit;}?> <main>
        <header class="cabecalho-home">
            <h2 class="cabecalho-home__titulo">Bem vindo ao Centro de Artes e Eventos de Passo Fundo!</h2>
            <p class="cabecalho-home__subtitulo"></p>
            <a class="cabecalho-home__role" href="#servicos">role para ver mais</a>
        </header>
        <section id="servicos" class="servicos"><!-- Seção serviços -->
            <div class="container">
                <h2 class="home__titulo">O que fazemos</h2>
                <?php $counter1=-1;  if( isset($fazemos) && ( is_array($fazemos) || $fazemos instanceof Traversable ) && sizeof($fazemos) ) foreach( $fazemos as $key1 => $value1 ){ $counter1++; ?>
                <section class="servicos__item anime">
                    <img src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                    <h2><?php echo htmlspecialchars( $value1["destitulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
                    <p class="servicos__texto"><?php echo htmlspecialchars( $value1["destext"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                </section>
                 <?php } ?>
               <!-- <section class="servicos__item anime">
                    <img src="/res/site/img/icone-formatura.png" alt="Ícone Centro de Artes e Eventos Formatura">
                    <h2>Formaturas</h2>
                    <p class="servicos__texto">Uma grande conquista que será lembrada a vida toda.</p>
                </section>
                <section class="servicos__item anime">
                    <img src="/res/site/img/icone-aniver.png" alt="Ícone Centro de Artes e Eventos Aniversario">
                    <h2>Aniversários & festas infantil</h2>
                    <p class="servicos__texto">Data única em nossas vidas que merece ser comemorada com grande festa.</p>
                </section>-->

              
            </div> <!-- fim container -->
        </section><!-- fim Seção serviços -->
        <section class="depoimentos"> <!-- seção depoimentos -->
            <div class="container">
                <h2 class="home__titulo home__titulo--branco anime">O que falam de nós</h2>
                <div class="depoimentos__caixa">
                     <?php $counter1=-1;  if( isset($post) && ( is_array($post) || $post instanceof Traversable ) && sizeof($post) ) foreach( $post as $key1 => $value1 ){ $counter1++; ?>
                    <section class="depoimentos__item">
                        <img class="depoimentos__img" src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="Foto da pessoa x">
                        
                        <p class="depoimentos__texto"> <?php echo FormataEditorPost($value1["destexto"]); ?></p>
                        
                        <p class="depoimentos__pessoa"><?php echo htmlspecialchars( $value1["desnome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
                    </section>
                     <?php } ?>
                    <!--
                    <section class="depoimentos__item">
                        <img class="depoimentos__img" src="/res/site/img/depoimentos/3_cli.jpg" alt="Foto da pessoa x">
                        <p class="depoimentos__texto">Espaço sofisticado com hall de entrada decorado,lustres artesanais,castiçais para mesas,espaço já com mesas e cadeiras, mesa com vidro temperado para doces e salgados, ambiente climatizado,portas e janelas acústicas.</p>
                        <p class="depoimentos__pessoa">Fabio Teixeira Melego</p>
                    </section>
                    <section class="depoimentos__item">
                        <img class="depoimentos__img" src="/res/site/img/depoimentos/1_cli.jpg" alt="Foto da pessoa x">
                        <p class="depoimentos__texto">QUER UM AMBIENTE BONITO, REQUINTADO, ACONCHEGANTE ,AGRADÁVEL PARA SUA FESTA 🥂🎶🎷🎷!!! O CENTRO DE ARTES E EVENTOS ESPERA POR VOCÊ FAÇA SEU ORÇAMENTO PELO FONE 5499900- 4814</p>
                        <p class="depoimentos__pessoa">Diana Pfluck</p>
                    </section>
                -->
                </div> <!-- depoimentos__caixa -->
            </div>
        </section><!-- fim seção depoimentos -->