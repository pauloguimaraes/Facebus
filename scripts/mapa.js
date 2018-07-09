/**
 ** Exercício de programação - Soluções Web baseadas em Software Livre
 ** Professor Doutor
 ** 
 ** Autores:
 ** Lucas
 ** Mateus
 ** Paulo Henrique Freitas Guimarães - 9390361
 ** 
 ** Funções JavaScript relacionadas ao mapa
 **/


 
var onibus = [];
var paradas = [];
var URL_Site = '//ec2-52-15-33-123.us-east-2.compute.amazonaws.com/Facebus/';



/**
 * Apresenta o mapa do MapBox, adicionando navegação e Geocoder
 * 
 * @param {*} token - Token do MapBox
 */
function showMap(token)
{
    mapboxgl.accessToken = token;

    // Instanciando o mapa
    var mapa = new mapboxgl.Map({
        container: 'mapa',
        style: 'mapbox://styles/mapbox/streets-v10',
        zoom: 15
    });

    // Adicionando controles de navegação
    mapa.addControl(new mapboxgl.NavigationControl());

    // Adicionando a barra de pesquisa
    var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken
    });
    document.getElementById('geocoder').appendChild(geocoder.onAdd(mapa));

    // Centralizando na localização atual
    navigator.geolocation.getCurrentPosition(
        // Função se consegue a localização
        function(location) {
            flyToCurrentLocation(mapa, location);
        },

        // Função se não consegue a localização
        function() {
            flyToSeCathedral(mapa);
        }
    );

    // No change da CheckBox atualizar a apresentação dos ônibus
    document.getElementById('onibus').addEventListener('change', function(element) {
        toggleOnibus(element, mapa);
    });

    // No change da CheckBox atualizar a apresentação das paradas
    document.getElementById('paradas').addEventListener('change', function(element) {
        toggleParadas(element, mapa);
    });

    // Adiciona a atualização do mapa no click do botão
    document.getElementById('atualizar_onibus').addEventListener('click', function(element) {
        atualizarMapa(mapa);
    });
}



/**
 * Centraliza o mapa em determinada localização
 * 
 * @param {*} mapa Mapa onde a localização vai ser centralizada
 * @param {*} location Posição a ser centralizada
 */
function flyToCurrentLocation(mapa, location)
{
    mapa.flyTo({
        center: [
            location.coords.longitude,
            location.coords.latitude
        ]
    });
}



/**
 * Centraliza o mapa na Catedral da Sé
 * 
 * @param {*} mapa Mapa que será centralizado
 */
function flyToSeCathedral(mapa)
{
    mapa.flyTo({
        center: [
            -46.6343,
            -23.5513
        ]
    });
}



/**
 * Atualiza os ônibus no mapa
 * 
 * @param {*} mapa Mapa onde os ônibus serão apresentados
 */
function atualizarMapa(mapa)
{
    if(onibus.length > 0)
    {
        removeAllOnibus(onibus);
        getCurrentBusPositions(mapa, true);
    }
}



/**
 * Apresenta as paradas de ônibus
 * 
 * @param {*} mapa Mapa onde as paradas serão apresentadas
 */
function getParadas(mapa) 
{
    var dict = [];
    $.ajax({
        type: 'GET',
        url: URL_Site + 'sptrans/getParadas.php?',
        dataType: 'json',

        // Com sucesso na chamada
        success: function(html) {
            // Preenche um dicionário com as paradas
            $.each(html, function(k, v) {
                dict[v.cp + ',' + v.ed] = [v.px, v.py]
            });
        },

        // Com erro na chamada
        error: function(xhr) {
            alert(xhr.responseText);
        },

        // Ao concluir a chamada plota os pontos no mapa
        complete: function(data) {
            for(const[key, value] of Object.entries(dict)) {
                try {
                    var splitted = key.split(',');
                    var codigo_parada = splitted[0];
                    var endereco_parada = splitted[1];

                    // Adiciona o marcador
                    var marker = new mapboxgl.Marker()
                        .setLngLat(dict[key])
                        .setPopup(new mapboxgl.Popup({ offset: 25})
                        .setHTML('<h3>' + codigo_parada + '</h3><p>' + endereco_parada + '</p>'))
                        .addTo(mapa);
                    // Adiciona o marcador na lista
                    paradas.push(marker);
                }
                catch(err) {
                    alert(err);
                }
            }
        }
    });
}



/**
 * Recupera os ônibus e os apresenta no mapa
 * 
 * @param {*} mapa Mapa onde os ônibus serão apresentados
 */
function getCurrentBusPositions(mapa, update)
{
    var dict = [];

    // Se deve-se atualizar
    var url_a_buscar = URL_Site + 'sptrans/getOnibus.php'
    if(update)
    {
        url_a_buscar = url_a_buscar + '?update=true'
    }

    $.ajax({
        type: 'GET',
        url: url_a_buscar,
        dataType: 'json',

        // Requisição ser bem sucedida
        success: function(html) {
            $.each(html, function(key, value) {
                var pos = value.vs;
                // Recuperando X e Y
                $.each(pos, function(k, v) {
                    dict[value.c + ',' + pos[k].p + ','  + value.lt0 + ' - ' + value.lt1] = [pos[k].px, pos[k].py]
                });
            });
        },

        // Erro na requisição
        error: function(xhr) {
            alert(xhr.responseText);
        },

        // Após a requisição estar completa
        complete: function(data) {
            for(const[key, value] of Object.entries(dict)) {
                try {
                    var splitted = key.split(',');
                    var numero_linha = splitted[0];
                    var descricao_linha = splitted[2];
                    
                    var el = document.createElement('div');
                    el.className = 'bus_marker';

                    // Adiciona um marcador
                    var marker = new mapboxgl.Marker(el)
                        .setLngLat(dict[key])
                        .setPopup(new mapboxgl.Popup({ offset: 25})
                        .setHTML('<h3>' + numero_linha + '</h3><p>' + descricao_linha + '</p>'))
                        .addTo(mapa);

                    // Adiciona o marcador na lista de ônibus
                    onibus.push(marker);
                }
                catch(err) {
                    alert(err);
                }
            }
            
            // Mostra o botão de atualizar
            document.getElementById('atualizar_onibus').style.visibility = 'visible';
        }
    });
}



/**
 * Remove todas as paradas do mapa
 * 
 * @param {*} paradas Lista de paradas para remover
 */
function removeAllParadas(paradas)
{
    // Remove do mapa
    for(var i = 0; i < paradas.length; i++)
    {
        paradas[i].remove();
    }

    // Remove da listagem
    while(paradas.length > 0)
    {
        paradas.pop();
    }
}



/**
 * Remove todos os ônibus do mapa
 * 
 * @param {*} onibus Lista de ônibus a remover
 */
function removeAllOnibus(onibus)
{
    // Remove do mapa
    for(var i = 0; i < onibus.length; i++)
    {
        onibus[i].remove();
    }
    
    // Remove da lista
    while(onibus.length > 0) 
    {
        onibus.pop();
    }

    // Esconde o botão de atualizar
    document.getElementById('atualizar_onibus').style.visibility = 'hidden';
}



/**
 * Manipula as paradas no mapa
 * 
 * @param {*} element Elemento de controle
 * @param {*} mapa Mapa onde as paradas serão adicionadas/removidas
 */
function toggleParadas(element, mapa)
{
    element.checked = !element.checked;

    // Se não tem paradas na lista
    if(paradas.length <= 0)
    {
        // Adiciona
        getParadas(mapa);
    }
    // Se tem paradas na lista
    else
    {
        // Remove todas
        removeAllParadas(paradas);
    }
}



/**
 * Manipula os ônibus no mapa
 * 
 * @param {*} element Elemento de controle
 * @param {*} mapa Mapa onde os ônibus serão adicionados/removidos
 */
function toggleOnibus(element, mapa)
{
    element.checked = !element.checked

    // Se não tem ônibus na lista
    if(onibus.length <= 0)
    {
        // Adiciona
        getCurrentBusPositions(mapa, false);
    }
    // Se tem ônibus na lista
    else
    {
        // Remove todas
        removeAllOnibus(onibus);
    }
}


