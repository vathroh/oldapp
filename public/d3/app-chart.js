
$.getJSON("/ajax-evaluation-result", function(DUMMY_DATA) {

    
    			

	var margin = {top: 20, right: 20, bottom: 30, left: 40},
		width = 960 - margin.left - margin.right,
		height = 500 - margin.top - margin.bottom;
    
    const x0 = d3.scaleBand().rangeRound([0, width]).padding(0.1);
    const x1 = d3.scaleBand();
	const y  = d3.scaleLinear().range([height, 0]);
	
	var color = d3.scaleBand().range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b"]);
	
	var xAxis = d3.axisBottom(x0);	
	var yAxis = d3.axisLeft(y).tickSizeOuter(0);
    
    const chartContainer = d3.select('svg')
			.attr('width', width + margin.left + margin.right)
			.attr('height', height + margin.top + margin.bottom)
			.attr('transform', "translate(" + margin.left + "," + margin.top + ")");	
    
	var answer = d3.keys(DUMMY_DATA[0]).filter(function(key) { return key !=="question";});
	
	
	DUMMY_DATA.forEach(function(data) {
		data.ans = answer.map(function(name) { return {name: name, value: +data[name]}; });
	});	
	
	x0.domain(DUMMY_DATA.map(function(d) { return d.question; }));
	x1.domain(answer).rangeRound([0, x0.range()]);	
	y.domain([0, d3.max(DUMMY_DATA, function(d) { return d3.max(d.question, function(d) { return d.value; }); })]);
	
	const chart = chartContainer.append('g');	
	
	chart.append('g')			
			.attr("transform", "translate(0," + height + ")")
			.attr("class", "x axis")
			.call(xAxis);
				
	chart.append("g")
		.attr("class", "y axis")
		.call(yAxis)
		.append("text")
		.attr("transform", "rotate(-90)")
		.attr("y", 6)
		.attr("dy", ".71em")
		.style("text-anchor", "end")
		.text("Evaluasi Topik");
	
	var state = chart.selectAll(".question")
		.data(DUMMY_DATA)
		.enter().append("g")
		.attr("class", "g")
		.attr("transform", function(d) { return "translate(" + x0(d.question) + ",0)"; });		
		
	state.selectAll("rect")
		.data(function(d) { return data.ans; })
		.enter().append("rect")
		.attr("width", x1.range())
		.attr("x", function(d) { return x1(d.name); })
		.attr("y", function(d) { return y(d.value); })
		.attr("height", function(d) { return height - y(d.value); })
		.style("fill", function(d) { return color(d.name); });



	/*
	
		const MARGIN = { top: 20, bottom: 10 };
		const CHART_WIDTH = 600;
		const CHART_HEIGHT = 400 - MARGIN.top - MARGIN.bottom;

		const x = d3.scaleBand().rangeRound([0, CHART_WIDTH]).padding(0.1);
		const y = d3.scaleLinear().range([CHART_HEIGHT, 0]);

		const chartContainer = d3.select('svg')
			.attr('width', CHART_WIDTH)
			.attr('height', CHART_HEIGHT + MARGIN.top + MARGIN.bottom);
		
		x.domain(DUMMY_DATA.map((d) => d.region));
		y.domain([0, d3.max(DUMMY_DATA, (d) => d.value) + 3]);
			
		const chart = chartContainer.append('g');

		chart
			.append('g')
			.attr('transform', `translate(0, ${CHART_HEIGHT})`)
			.call(d3.axisBottom(x).tickSizeOuter(0))
			.attr('color', '#4f009e');

		chart
			.selectAll('.bar')
			.data(DUMMY_DATA)
			.enter()
			.append('rect')
			.classed('bar', true)
			.attr('width', x.bandwidth())
			.attr('height', (data) => CHART_HEIGHT - y(data.value))
			.attr('x', (data) => x(data.region))
			.attr('y', (data) => y(data.value))
			.style('fill', 'purple');

		chart
			.selectAll('label')
			.data(DUMMY_DATA)
			.enter()
			.append('text')
			.text((data) => data.value)
			.attr('x', data => x(data.region) + x.bandwidth() / 2)
			.attr('y', data => y(data.value)-15)
			.attr('text-anchor', 'middle')
			.classed('label', 'true');
			
		
		
		*/

});



				
		

