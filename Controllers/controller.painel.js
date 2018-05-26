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
                backgroundColor: 'orange'
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

//Função do gráfico de Mensalidades
var ctx = document.getElementsByClassName("receita-mensalidades");

var jan = (document.getElementById("jan").value);
var fev = (document.getElementById("fev").value);
var mar = (document.getElementById("mar").value);
var abr = (document.getElementById("abr").value);
var mai = (document.getElementById("mai").value);
var jun = (document.getElementById("jun").value);
var myBarChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Agt", "Set", "Out", "Nov", "Dez"],
        datasets: [{
                label: 'Mensalidades',
                data: [jan, fev, mar, abr, mai, jun],
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

var ctx = document.getElementsByClassName("ranking-vendas");

var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["João da Silva", "Diego Humberto", "Renato da Costa", "Matheus Alves", "Max Miller", "Geovana Marquues", "Pablo Escobar"],
        datasets: [{
                label: 'Vendas por usuário',
                data: [1000, 670, 850, 900, 780, 740, 823],
                borderColor: 'white',
                backgroundColor: 'blue'
            }]
    },
    options: {
        title: {
            display: true,
            fontSize: 20,
            text: "Ranking de Vendas"
        },
        labels: {
            fontStyle: "bold"
        }
    }
});

var ctx = document.getElementsByClassName("qtd-vendas");

var janV = (document.getElementById("janV").value);
var fevV = (document.getElementById("fevV").value);
var marV = (document.getElementById("marV").value);

var myBarChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Agt", "Set", "Out", "Nov", "Dez"],
        datasets: [
            {
                label: 'Nº de Vendas',
                data: [janV, fevV, marV, 90, 70, 74, 23],
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

var ctx = document.getElementsByClassName("total-vendas");

var myBarChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Agt", "Set", "Out", "Nov", "Dez"],
        datasets: [{
                label: 'Vendas',
                data: [1000, 670, 850, 900, 780, 740, 823, 0, 0],
                borderColor: '#009933',
                backgroundColor: '#66ff66'
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