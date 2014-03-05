$.extend
(
	stat,
	{
		chartIdSuffix: '#chart-',
		charts: {},

		beforeInitCallbacks: [],
		afterInitCallbacks: [],
		beforeChangeCallback: [],
		afterChangeCallback: [],

		maxSimultaneousRequest: 3,
		processingRequestsNumber: 0,
		pendingRequests: [],

		translateFunctions: function(object)
			{
				$.each
				(
					object,
					function(key, value)
					{
						if (Object.prototype.toString.call(value) === '[object Array]' || (value !== null && typeof value == 'object')) 
							object[key] = stat.translateFunctions(value);
						else if (typeof(value) == 'string' && (value.indexOf('function(') !== -1 || value.indexOf('function (') !== -1))
							object[key] = eval('(' + value + ')');			
					}
				);
				return object;
			},

		loadCharts: function(shouldReset)
			{
				$('.chart').each
			    (
			        function ()
			        {
			            var elem = $(this),
			                statId = elem.data('statid'),
			                assemblyId = elem.data('assemblyid'),
			                chartId = assemblyId + '-' + statId;
			                isDisplayed = (elem.css('display') !== 'none');
			            if (stat.charts[chartId] === undefined)
			            	stat.charts[chartId] = {isLoaded: false, chart: null};
			            if (!elem.hasClass('tab-content'))
			                isDisplayed = (elem.parents('.tab-content').css('display') !== 'none');
			            if (shouldReset)
			                stat.charts[chartId].isLoaded = false;
			            if (isDisplayed && !stat.charts[chartId].isLoaded)
			                stat.loadChart(statId, assemblyId, elem);
			        }
			    );
			},

		loadChart: function(statId, assemblyId, chart)
			{
				var options = 
						{
							  lines: 13, // The number of lines to draw
							  length: 10, // The length of each line
							  width: 10, // The line thickness
							  radius: 30, // The radius of the inner circle
							  corners: 1, // Corner roundness (0..1)
							  rotate: 0, // The rotation offset
							  direction: 1, // 1: clockwise, -1: counterclockwise
							  color: '#ccc', // #rgb or #rrggbb
							  speed: 1.7, // Rounds per second
							  trail: 36, // Afterglow percentage
							  shadow: false, // Whether to render a shadow
							  hwaccel: true, // Whether to use hardware acceleration
							  className: 'spinner', // The CSS class to assign to the spinner
							  zIndex: 2e9, // The z-index (defaults to 2000000000)
							  top: 'auto', // Top position relative to parent in px
							  left: 'auto' // Left position relative to parent in px
						},
					spinner = new Spinner(options).spin(chart.get(0)),
					data = '',
					fields = $(stat.chartIdSuffix + statId).parents('.chart').find('.chartInput').serializeArray(),
					chartId = assemblyId + '-' + statId;

				$.each
				(
					fields,
					function(i, field)
					{
						if (data !== '')
							data += '&';
						data += 'criteria[' + field.name + ']=' + field.value;
					}
				);

				$.each
				(
					stat.criteriaProviders,
					function(i, criteriaProvider)
					{
						$.each
						(
							criteriaProvider.getCriteria(),
							function(j, criterium)
							{
								if (data !== '')
									data += '&';
								data += 'criteria[' + criterium.name.replace(']', '').split('[').join('][') + ']=' + criterium.value;
							}
						);
					}
				)

				stat.sendAjaxRequest
				(
					{
						url: stat.baseUrl + '/stat/' + locale + '/buildChart/' + statId,
						dataType: 'json',
						type: 'GET',
						data: data,
						success:
							function (chart, status)
							{
								var scrollTop = $('body').scrollTop();
								$(stat.chartIdSuffix + chartId).css('min-height', 'auto').css('height', 'auto');
								stat.charts[chartId].type = chart.type;
								stat.charts[chartId].isLoaded = true;
								chart.data = stat.translateFunctions(chart.data);
								switch (chart.type)
								{
									case 'highcharts':
										if (chart.data.chart === undefined)
											chart.data.chart = {};
										chart.data.chart.renderTo = 'chart-' + chartId;
										stat.charts[chartId].chart = new Highcharts.Chart(chart.data);
										break;
									case 'da.widget':
										chart.data.renderTo = 'chart-' + chartId;
										stat.charts[chartId].chart = new da.widget[chart.data.type](chart.data);
										break;
									default:
										console.log('The type of chart "' + chart.type + '" is not handled.');
								}
								$(window).resize();
								$('body').scrollTop(scrollTop);
							},
						error:
							function (jqXHR, textStatus, errorThrown)
							{ 
								//alert('The request to [/stat/' + locale + '/buildChart/' + statId + '] failed. The [' + textStatus + '] thrown is: [' + errorThrown + '].');
								console.log('The request to [/stat/' + locale + '/buildChart/' + statId + '] failed. The [' + textStatus + '] thrown is: [' + errorThrown + '].');
								$(stat.chartIdSuffix + chartId).children().remove();
							},
						complete:
							function ()
							{
								stat.processingRequestsNumber--;
								spinner.stop();
							}
					}
				);
			},

		sendAjaxRequest: function(request)
			{
				stat.pendingRequests.push(request);

				var processRequest = function () {
					if (stat.processingRequestsNumber < stat.maxSimultaneousRequest) {
						stat.processingRequestsNumber++;
					
						if (stat.pendingRequests.length > 0) {
							var request = stat.pendingRequests.pop();
							$.ajax(request);
							
							if (stat.pendingRequests.length > 0) {
								processRequest();
							}
						}
					} else if (stat.pendingRequests.length > 0) {
						setTimeout(processRequest, 200);
					}
				};

				processRequest();
			},

		addBeforeInitCallback: function(callback)
			{
				stat.beforeInitCallbacks.push(callback);
			},

		addAfterInitCallback: function(callback)
			{
				stat.afterInitCallbacks.push(callback);
			},

		addBeforeChangeCallback: function(callback)
			{
				stat.beforeChangeCallback.push(callback);
			},

		addAfterChangeCallback: function(callback)
			{
				stat.afterChangeCallback.push(callback);
			}
	}
);


(function ()
{ 
 	return Highcharts.Color(Highcharts.getOptions().colors[1]).setOpacity(0.1).get("rgba"); 
})()
