// Função que mostra gráfico de alunos ativos e inativos
var ctx = document.getElementsByClassName("grafico-alunos");
//recebendo valor do input
var ativos = (document.getElementById("ativos").value);
var inativos = (document.getElementById("inativos").value);

//iniciando um novo objeto Chat para criar o gráfico:
var AlunosAI = new Chart(ctx, {

    type: 'doughnut',
    data: {
        labels: ["Ativos", "Inativos"],
        datasets: [{
                data: [ativos, inativos],
                borderColor: 'White',
                backgroundColor: '#ff9966'
            }]
    },
    options: {
        title: {
            display: true,
            fontSize: 20,
            text: "Gráfico geral de alunos"
        },
        labels: {
            fontStyle: "bold"
        }
    }
});

//Função do gráfico de Mensalidades:
var ctx = document.getElementsByClassName("receita-mensalidades");
//Recebendo valor de cada mês:
var janM = (document.getElementById("janM").value);
var fevM = (document.getElementById("fevM").value);
var marM = (document.getElementById("marM").value);
var abrM = (document.getElementById("abrM").value);
var maiM = (document.getElementById("maiM").value);
var junM = (document.getElementById("junM").value);
var julM = (document.getElementById("julM").value);
var agtM = (document.getElementById("agtM").value);
var setM = (document.getElementById("setM").value);
var outM = (document.getElementById("outM").value);
var novM = (document.getElementById("novM").value);
var dezM = (document.getElementById("dezM").value);

//Criando o gráfico:
var myBarChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Agt", "Set", "Out", "Nov", "Dez"],
        datasets: [{
                label: 'Mensalidades',
                data: [janM, fevM, marM, abrM, maiM, junM, julM, agtM, setM, outM, novM, dezM],
                borderColor: 'black',
                backgroundColor: '#ff0066'
            }]
    },
    options: {
        title: {
            display: true,
            fontSize: 20,
            text: "Receita de Mensalidades"
        },
        labels: {
            fontStyle: "bold"
        }
    }
});

//Grafico de Quantidade de Vendas no ano:
var ctx = document.getElementsByClassName("qtd-vendas");
//recevendo valor de cada mês:
var janeiroV = (document.getElementById("janV").value);
var fevereiroV = (document.getElementById("fevV").value);
var marcoV = (document.getElementById("marV").value);
var abrilV = (document.getElementById("abrV").value);
var maioV = (document.getElementById("maiV").value);
var junhoV = (document.getElementById("junV").value);
var julhoV = (document.getElementById("julV").value);
var agostoV = (document.getElementById("agtV").value);
var setembroV = (document.getElementById("setV").value);
var outubroV = (document.getElementById("outV").value);
var novembroV = (document.getElementById("novV").value);
var dezembroV = (document.getElementById("dezV").value);

//Criando o gráfico:
var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Agt", "Set", "Out", "Nov", "Dez"],
        datasets: [
            {
                label: 'Nº de Vendas',
                data: [janeiroV, fevereiroV, marcoV, abrilV, maioV, junhoV, julhoV, agostoV, setembroV, outubroV, novembroV, dezembroV ],
                borderColor: '#0099cc',
                backgroundColor: '#00ffff'
            }            
        ]
    },
    options: {
        title: {
            display: true,
            fontSize: 20,
            text: "Vendas por mês"
        },
        labels: {
            fontStyle: "bold"
        }
    }
});

//Gráfico de Receitas de Venda no ano:
var ctx = document.getElementsByClassName("total-vendas");
//Recebendo o valor das variavéis:
var janeiroRV = (document.getElementById("janRV").value);
var fevereiroRV = (document.getElementById("fevRV").value);
var marcoRV = (document.getElementById("marRV").value);
var abrilRV = (document.getElementById("abrRV").value);
var maioRV = (document.getElementById("maiRV").value);
var junhoRV = (document.getElementById("junRV").value);
var julhoRV = (document.getElementById("julRV").value);
var agostoRV = (document.getElementById("agtRV").value);
var setembroRV = (document.getElementById("setRV").value);
var outubroRV = (document.getElementById("outRV").value);
var novembroRV = (document.getElementById("novRV").value);
var dezembroRV = (document.getElementById("dezRV").value);
//Criando o gráfico:
var myBarChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Agt", "Set", "Out", "Nov", "Dez"],
        datasets: [{
                label: 'Vendas',
                data: [janeiroRV, fevereiroRV, marcoRV, abrilRV, maioRV, junhoRV, julhoRV, agostoRV, setembroRV, outubroRV, novembroRV, dezembroRV],
                borderColor: '#009933',
                backgroundColor: '#eb99ff'
            }]
    },
    options: {
        title: {
            display: true,
            fontSize: 20,
            text: "Receita de Vendas"
        },
        labels: {
            fontStyle: "bold"
        }
    }
});