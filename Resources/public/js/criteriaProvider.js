$.extend
(
	stat,
	{
		criteriaProviders: {},
		
		CriteriaProvider: function()
			{
				this.criteria = [];
			},

		addCriteriaProvider: function(id)
			{
				var criteriaProvider = new stat.CriteriaProvider();
				stat.criteriaProviders[id] = criteriaProvider;
				return criteriaProvider;
			}
	}
);

(function(_class)
{
	_class.prototype.getCriteria = function()
	{
		return this.criteria;
	}

	_class.prototype.addCriterium = function(name, value)
	{
		this.criteria.push({name: name, value: value});
	}
})(stat.CriteriaProvider)