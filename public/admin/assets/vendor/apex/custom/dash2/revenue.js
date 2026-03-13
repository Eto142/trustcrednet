
// Chart 4
var options4 = {
	chart: {
		height: 74,
		type: "area",
		toolbar: {
			show: false,
		},
	},
	dataLabels: {
		enabled: false,
	},
	stroke: {
		curve: "smooth",
		width: 3,
	},
	series: [
		{
			name: "Revenue",
			data: [10, 40, 15, 40, 35, 96, 69],
		},
	],
	grid: {
		borderColor: "#e0e6ed",
		strokeDashArray: 5,
		xaxis: {
			lines: {
				show: true,
			},
		},
		yaxis: {
			lines: {
				show: false,
			},
		},
		padding: {
			top: -20,
			right: -20,
			bottom: -20,
			left: -20,
		},
	},
	xaxis: {
		labels: {
			show: false,
		},
	},
	yaxis: {
		labels: {
			show: false,
		},
	},
	colors: ["#276dd9"],
	markers: {
		size: 0,
		opacity: 0.3,
		colors: ["#276dd9"],
		strokeColor: "#ffffff",
		strokeWidth: 5,
		hover: {
			size: 7,
		},
	},
	tooltip: {
		y: {
			formatter: function (val) {
				return +val + "k";
			},
		},
	},
};
var chart = new ApexCharts(document.querySelector("#bestSeller"), options4);

chart.render();
