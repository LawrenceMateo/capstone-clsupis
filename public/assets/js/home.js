const main = () => {
    pieSector();
    pieField();
}

const pieSector = () => {
    
    var data = [];
    var res = [];
    var ctx = document.getElementById('pieChart').getContext('2d');
    var color = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(114, 202, 204)', 'rgb(153, 102, 255)', 'rgb(204, 204, 208)', 'rgb(255, 159, 64)', 'rgb(0, 102, 153)'];
    var html = '';

    $.ajax({
        type : 'GET',
        url : '../../views/php/pieChartProject.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response){
            
            for(i=0; i<response.data.length; i++){
                data.push(response.data[i].sector_name);
                res.push(response.sectorCount[i].sector_count)
            }   

            var result = res.map(function(x){
                return parseInt(x, 10);
            });

            var sectorData = [{
                data: res,
                label: 'My First dataset',
                backgroundColor: color
            }];

            var options = {
                legend: {
                    display: true,
                    responsive: true
                },
                plugins: {
                    datalabels: {
                        color: '#fff',
                        anchor: 'end',
                        align: 'start',
                        offset: 10,
                        font: {
                            weight: 'bold',
                            size: '10'
                        },
                        formatter: (value) => {
                            let sum = 0;
                            let dataArr = result;
                            dataArr.map(value => {
                                sum += value;
                            });
                            let percentage = (value*100 / sum).toFixed(2)+"%";
                            if(percentage != '0.00%' && value != 0 ){
                                return percentage;
                            }
                        }
                    }
                }
            };

            var chart = new Chart(ctx, {
                type: 'pie',
        
                data: {
                    labels: data,
                    datasets: sectorData 
                },
        
                options: options
            });

            html += `<tbody>`;
            for(i=0; i<response.data.length; i++){
                html += `   
                            <tr>
                                <th>${response.data[i].sector_name} :</th> 
                                <td>${response.sectorCount[i].sector_count}</td>
                            </tr>    
                        `;
            }
            html += `</tbody>`;

            $('#pie-sector-data').html(html);
        }
    });
}

const pieField = () => {
    
    var data = [];
    var res = [];
    var ctx = document.getElementById('pieChartField').getContext('2d');
    var color = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(114, 202, 204)', 'rgb(153, 102, 255)', 'rgb(204, 204, 208)', 'rgb(255, 159, 64)', 'rgb(0, 102, 153)'];
    var html = '';

    $.ajax({
        type : 'GET',
        url : '../../views/php/pieChartField.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response){
            
            for(i=0; i<response.data.length; i++){
                data.push(response.data[i].name);
                res.push(response.fieldCount[i].field_count)
            }   

            var result = res.map(function(x){
                return parseInt(x, 10);
            });

            var sectorData = [{
                data: res,
                label: 'My First dataset',
                backgroundColor: color
            }];

            var options = {
                legend: {
                    display: true,
                    responsive: true
                },
                plugins: {
                    datalabels: {
                        color: '#fff',
                        anchor: 'end',
                        align: 'start',
                        offset: 10,
                        font: {
                            weight: 'bold',
                            size: '10'
                        },
                        formatter: (value) => {
                            let sum = 0;
                            let dataArr = result;
                            dataArr.map(value => {
                                sum += value;
                            });
                            let percentage = (value*100 / sum).toFixed(2)+"%";
                            if(percentage != '0.00%' && value != 0 ){
                                return percentage;
                            }
                        }
                    }
                }
            };

            var chart = new Chart(ctx, {
                type: 'pie',
        
                data: {
                    labels: data,
                    datasets: sectorData 
                },
        
                options: options
            });

            html += `<tbody>`;
            for(i=0; i<response.data.length; i++){
                html += `   
                            <tr>
                                <th>${response.data[i].name} :</th> 
                                <td>${response.fieldCount[i].field_count}</td>
                            </tr>    
                        `;
            }
            html += `</tbody>`;

            $('#pie-field-data').html(html);
        }
    });
}

const lineByGender = () => {
    var data = [];
    var res = [];
    var ctx = document.getElementById('pieChartField').getContext('2d');
    var color = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)'];
    var html = '';

    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
}


jQuery(document).ready(function(){
    main();

    $('#printPie').on('click', function(){
        var canvas  = document.querySelector('#pieChart');
        var canvasImg = canvas.toDataURL('image/png', 1.0);
        var pdf = new jsPDF('landscape','in', 'letter');
        pdf.addImage(canvasImg, 'png', .5, 1.75, 10, 5);
        pdf.autoPrint();
        var blob = pdf.output("bloburl");
        window.open(blob);
    });

    $('#printPieField').on('click', function(){
        var canvas  = document.querySelector('#pieChartField');
        var canvasImg = canvas.toDataURL('image/png', 1.0);
        var pdf = new jsPDF('landscape','in', 'letter');
        pdf.addImage(canvasImg, 'png', .5, 1.75, 10, 5);
        pdf.autoPrint();
        var blob = pdf.output("bloburl");
        window.open(blob);
    });
});