var ctx = document.getElementsByClassName("grafico-alunos");

var myBarChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Ativos", "Inativos"],
        datasets: [{
                data: [100, 20],
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

var ctx = document.getElementsByClassName("receita-mensalidades");

var myBarChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul"],
        datasets: [{
                label: 'Mensalidades',
                data: [1000, 670, 850, 900, 780, 740, 823],
                borderColor: '#009933',
                backgroundColor: '#66ff66'
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

var ctx = document.getElementsByClassName("vendas-usuario");

var myBarChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul"],
        datasets: [
            {
                label: 'João da Silva',
                data: [10, 67, 50, 90, 70, 74, 23],
                borderColor: 'blue',
                backgroundColor: 'transparent'
            },
            {
                label: "Diego Humberto",
                data: [40, 10, 20, 20, 60, 30, 40],
                borderWidth: 3,
                borderColor: 'green',
                backgroundColor: 'transparent'
            },
            {
                label: "Matheus Alves",
                data: [40, 60, 50, 70, 60, 30, 70],
                borderWidth: 3,
                borderColor: 'red',
                backgroundColor: 'transparent'
            },
            {
                label: 'Renato da Silva',
                data: [10, 67, 85, 90, 78, 74, 23, 90],
                borderColor: 'orange',
                backgroundColor: 'transparent'
            }
        ]
    },
    options: {
        title: {
            display: true,
            fontSize: 20,
            text: "Vendas por Usuário"
        },
        labels: {
            fontStyle: "bold"
        }
    }
});

