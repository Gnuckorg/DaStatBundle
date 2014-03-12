// This component need the JQuery to work (http://jquery.com/download/).
// This component need the da.js file to be included before.
$.extend
(
	da.widget,
	{
		Table: function(options)
			{   
               // alert(JSON.stringify(options));
                this.title = '';
				this.table = {};
                this.parsedJson;
                this.linkText;
				if (options)
					this.build(options);
			}
	}
);

/**
     * JavaScript format string function
     * 
     */
    String.prototype.format = function()
    {
        var args = arguments;

        return this.replace(/{(\d+)}/g, function(match, number)
        {
            return typeof args[number] != 'undefined' ? args[number] :
                    '{' + number + '}';
        });
    };

// Definition of the class table.Table.
(function()
{
	// Public methods.
	da.widget.Table.prototype.build = function(options) 
	{
		if (options === undefined)
		{
			console.log('The building of the table need some options to be defined.');
			return;
		}

		if (options.renderTo === undefined)
		{
			console.log('The building of the table need an options "renderTo", which is the id of the html element where the map will be rendered, to be defined.');
			return;
		}

		if (options.title)
			this.title = options.title;

        if (options.values)
			this.values = options.values;

        var table = convertJsonToTable(this.values, null, null, this.linkText, options);

        $('#' + options.renderTo).html(table);
	};

	// Private properties and methods.
    /**
     * Convert a Javascript Oject array or String array to an HTML table
     * JSON parsing has to be made before function call
     * It allows use of other JSON parsing methods like jQuery.parseJSON
     * http(s)://, ftp://, file:// and javascript:; links are automatically computed
     *
     * JSON data samples that should be parsed and then can be converted to an HTML table
     *     var objectArray = '[{"Total":"34","Version":"1.0.4","Office":"New York"},{"Total":"67","Version":"1.1.0","Office":"Paris"}]';
     *     var stringArray = '["New York","Berlin","Paris","Marrakech","Moscow"]';
     *     var nestedTable = '[{ key1: "val1", key2: "val2", key3: { tableId: "tblIdNested1", tableClassName: "clsNested", linkText: "Download", data: [{ subkey1: "subval1", subkey2: "subval2", subkey3: "subval3" }] } }]'; 
     *
     * Code sample to create a HTML table Javascript String
     *     var jsonHtmlTable = convertJsonToTable(eval(dataString), 'jsonTable', null, 'Download');
     *
     * Code sample explaned
     *  - eval is used to parse a JSON dataString
     *  - table HTML id attribute will be 'jsonTable'
     *  - table HTML class attribute will not be added
     *  - 'Download' text will be displayed instead of the link itself
     *
     * @author Afshin Mehrabani <afshin dot meh at gmail dot com>
     * 
     * @class convertJsonToTable
     * 
     * @method convertJsonToTable
     * 
     * @param parsedJson object Parsed JSON data
     * @param tableId string Optional table id 
     * @param tableClassName string Optional table css class name
     * @param linkText string Optional text replacement for link pattern
     *  
     * @return string Converted JSON to HTML table
     */
    convertJsonToTable = function(parsedJson, tableId, tableClassName, linkText, options)
    {   
        // Patterns for links and NULL value
        var italic = '<i>{0}</i>',
            link = linkText ? '<a href="{0}">' + linkText + '</a>' : '<a href="{0}">{0}</a>'
        ;

        // Pattern for table                          
        var idMarkup = tableId ? ' id="' + tableId + '"' : '',
            classMarkup = tableClassName ? ' class="' + tableClassName + '"' : ''
        ;

        if (JSON.stringify(options.values).length > 2) {
			this.title = options.title;

            var tbl = '<h2>'+ this.title + '</h2><table border="1" cellpadding="5" cellspacing="5"' + idMarkup + classMarkup + '>{0}{1}</table><br /><br />',
            // Patterns for table content
                th = '<thead>{0}</thead>',
                tb = '<tbody>{0}</tbody>',
                tr = '<tr>{0}</tr>',
                thRow = '<th>{0}</th>',
                tdRow = '<td>{0}</td>',
                thCon = '',
                tbCon = '',
                trCon = ''
            ;

            if (parsedJson) {
                var isStringArray = false,
                    headers,
                    isAssociativeArray = undefined === parsedJson[0]
                ;

                for (var i in parsedJson) {
                    if (typeof(parsedJson[i]) !== 'object') {
                        isStringArray = true;
                    }

                    break;
                }

                // Create table headers from JSON data
                // If JSON data is a simple string array we create a single table header
                if (isStringArray && !isAssociativeArray) {
                    thCon += thRow.format('value');
                } else {
                    // If JSON data is an object array, headers are automatically computed
                    for (var i in parsedJson) {
                        if (typeof(parsedJson[i]) === 'object') {
                            headers = array_keys(parsedJson[i]);

                            for (j = 0; j < headers.length; j++) {
                                thCon += thRow.format(headers[j]);
                            }
                        }

                        break;
                    }
                }

                th = th.format(tr.format(thCon));

                // Create table rows from Json data
                if (isStringArray) {
                    for (var i in parsedJson) {
                        if (isAssociativeArray) {
                            tbCon += thRow.format(i);
                        }

                        tbCon += tdRow.format(parsedJson[i]);
                        trCon += tr.format(tbCon);
                        tbCon = '';
                    }
                }
                else {
                    if (headers) {
                        var urlRegExp = new RegExp(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig);
                        var javascriptRegExp = new RegExp(/(^javascript:[\s\S]*;$)/ig);

                        for (i = 0; i < parsedJson.length; i++) {
                            if (isAssociativeArray) {
                                tbCon += thRow.format(i);
                            }

                            for (j = 0; j < headers.length; j++) {
                                var value = parsedJson[i][headers[j]];
                                var isUrl = urlRegExp.test(value) || javascriptRegExp.test(value);

                                if (isUrl) {  // If value is URL we auto-create a link
                                    tbCon += tdRow.format(link.format(value));
                                } else {
                                    if (value) {
                                        if (typeof(value) === 'object') {
                                            //for supporting nested tables
                                            tbCon += tdRow.format(convertJsonToTable(eval(value.data), value.tableId, value.tableClassName, value.linkText));
                                        } else {
                                            tbCon += tdRow.format(value);
                                        }

                                    } else {    // If value == null we format it like PhpMyAdmin NULL values
                                        tbCon += tdRow.format(italic.format(value).toUpperCase());
                                    }
                                }
                            }

                            trCon += tr.format(tbCon);
                            tbCon = '';
                        }
                    }
                }

                tb = tb.format(trCon);
                tbl = tbl.format(th, tb);

                return tbl;
            }
            return null;
        } else {
            return null;
        }
    }

    /**
     * Return just the keys from the input array, optionally only for the specified search_value
     * version: 1109.2015
     *  discuss at: http://phpjs.org/functions/array_keys
     *  +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
     *  +      input by: Brett Zamir (http://brett-zamir.me)
     *  +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
     *  +   improved by: jd
     *  +   improved by: Brett Zamir (http://brett-zamir.me)
     *  +   input by: P
     *  +   bugfixed by: Brett Zamir (http://brett-zamir.me)
     *  *     example 1: array_keys( {firstname: 'Kevin', surname: 'van Zonneveld'} );
     *  *     returns 1: {0: 'firstname', 1: 'surname'}
     */
    array_keys = function(input, search_value, argStrict)
    {
        var search = typeof search_value !== 'undefined', tmp_arr = [], strict = !!argStrict, include = true, key = '';

        if (input && typeof input === 'object' && input.change_key_case) { // Duck-type check for our own array()-created PHPJS_Array
            return input.keys(search_value, argStrict);
        }

        for (key in input)
        {
            if (input.hasOwnProperty(key))
            {
                include = true;
                if (search)
                {
                    if (strict && input[key] !== search_value)
                        include = false;
                    else if (input[key] != search_value)
                        include = false;
                }
                if (include)
                    tmp_arr[tmp_arr.length] = key;
            }
        }
        return tmp_arr;
    };
}
)();