<?php if(!class_exists('Rain\Tpl')){exit;}?> <header class="pagina-cabecalho">
            <h1 class="pagina-cabecalho__titulo anime">Contato</h1>
        </header>
        <section class="container pagina-conteudo">
            
            <p align="center" class="servicos__texto">Envie-nos um e-mail utilizando o formulário abaixo,<br>
            e informe o nome e seu e-mail corretamente para agilizarmos o atendimento.</p>

            <form action="/contato" class="formulario anime" method="post">
                <div class="formulario__grupo formulario__grupo--coluna-esq">
                    <label class="formulario__label" for="nome">Nome</label><br>
                    <input class="formulario__campo" id="nome" type="text" name="nome">
                </div>
                <div class="formulario__grupo formulario__grupo--coluna-dir">
                    <label class="formulario__label" for="email">E-mail</label><br>
                    <input class="formulario__campo" id="email" type="email" name="email">
                </div>
               <div class="formulario__grupo">
                    <label class="formulario__label" for="mensagem">Mensagem</label><br>
                    <textarea class="formulario__campo" name="mensagem" id="mensagem" cols="30" rows="10"></textarea>
                </div> 
                <input type="submit" class="formulario__botao" value="Enviar" name="submit">
            </form>
        </section>
        <div class="mapa anime">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3514.32955218174!2d-52.39834728525504!3d-28.258022457450647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94e2bf87098fa911%3A0x2ff2073725d91206!2sR.+Independ%C3%AAncia%2C+334+-+Centro%2C+Passo+Fundo+-+RS%2C+99010-040!5e0!3m2!1spt-BR!2sbr!4v1558101270591!5m2!1spt-BR!2sbr" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>