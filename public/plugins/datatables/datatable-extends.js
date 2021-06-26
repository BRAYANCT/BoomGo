function init(){
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-eu-pre": function ( date ) {
            date = date.replace(" ", "");

            if ( ! date ) {
                return 0;
            }

            var year;
            var eu_date = date.split(/[\.\-\/]/);

            /*year (optional)*/
            if ( eu_date[2] ) {
                year = eu_date[2];
            }
            else {
                year = 0;
            }

            /*month*/
            var month = eu_date[1];
            if ( month.length == 1 ) {
                month = 0+month;
            }

            /*day*/
            var day = eu_date[0];
            if ( day.length == 1 ) {
                day = 0+day;
            }

            return (year + month + day) * 1;
        },

        "date-eu-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-eu-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );


    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "time-uni-pre": function (a) {
            var uniTime;

            if (a.toLowerCase().indexOf("am") > -1 || (a.toLowerCase().indexOf("pm") > -1 && Number(a.split(":")[0]) === 12)) {
                uniTime = a.toLowerCase().split("pm")[0].split("am")[0];
                while (uniTime.indexOf(":") > -1) {
                    uniTime = uniTime.replace(":", "");
                }
            } else if (a.toLowerCase().indexOf("pm") > -1 || (a.toLowerCase().indexOf("am") > -1 && Number(a.split(":")[0]) === 12)) {
                uniTime = Number(a.split(":")[0]) + 12;
                var leftTime = a.toLowerCase().split("pm")[0].split("am")[0].split(":");
                for (var i = 1; i < leftTime.length; i++) {
                    uniTime = uniTime + leftTime[i].trim().toString();
                }
            } else {
                uniTime = a.replace(":", "");
                while (uniTime.indexOf(":") > -1) {
                    uniTime = uniTime.replace(":", "");
                }
            }
            return Number(uniTime);
        },

        "time-uni-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "time-uni-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });


    (function (factory) {
        if (typeof define === "function" && define.amd) {
            define(["jquery", "moment", "datatables.net"], factory);
        } else {
            factory(jQuery, moment);
        }
    }(function ($, moment) {

        $.fn.dataTable.moment = function ( format, locale, reverseEmpties ) {
            var types = $.fn.dataTable.ext.type;

            // Add type detection
            types.detect.unshift( function ( d ) {
                if ( d ) {
                    // Strip HTML tags and newline characters if possible
                    if ( d.replace ) {
                        d = d.replace(/(<.*?>)|(\r?\n|\r)/g, '');
                    }

                    // Strip out surrounding white space
                    d = $.trim( d );
                }

                // Null and empty values are acceptable
                if ( d === '' || d === null ) {
                    return 'moment-'+format;
                }

                return moment( d, format, locale, true ).isValid() ?
                    'moment-'+format :
                    null;
            } );

            // Add sorting method - use an integer for the sorting
            types.order[ 'moment-'+format+'-pre' ] = function ( d ) {
                if ( d ) {
                    // Strip HTML tags and newline characters if possible
                    if ( d.replace ) {
                        d = d.replace(/(<.*?>)|(\r?\n|\r)/g, '');
                    }

                    // Strip out surrounding white space
                    d = $.trim( d );
                }

                return !moment(d, format, locale, true).isValid() ?
                    (reverseEmpties ? -Infinity : Infinity) :
                    parseInt( moment( d, format, locale, true ).format( 'x' ), 10 );
            };
        };

    }));
    //agregar todos los formatos que se necesite
    $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );


}

let dtExtends = {};

dtExtends =  {
    init,
}

export default dtExtends
