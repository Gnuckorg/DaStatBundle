stat = {};

$(document).ready
(
	function()
	{
		$('.chartInput').change
		(
			function()
			{
				var chart = $(this).parents('.chart');

				$.each
				(
					stat.beforeChangeCallbacks,
					function (key, callback)
					{
						callback.call(stat, chart);
					}
				);

				stat.loadChart(chart.data('statid'));

				$.each
				(
					stat.afterChangeCallbacks,
					function (key, callback)
					{
						callback.call(stat, chart);
					}
				);
			}
		);

		$.each
		(
			stat.beforeInitCallbacks,
			function (key, callback)
			{
				callback.call(stat);
			}
		);

		stat.loadCharts();

		$.each
		(
			stat.afterInitCallbacks,
			function (key, callback)
			{
				callback.call(stat);
			}
		);
	}
);