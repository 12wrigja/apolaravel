module.exports = function (Resources) {
    return Resources.Vue.extend({
        props: {
            bgcolor: {
                type: String
            },
            width: {
                type: Number,
                default: 150
            },
            height: {
                type: Number,
                default: 150
            },
            parts: {
                type: String
            },
            ordered: {
                type: Boolean,
                default: false
            }
        },
        template: require('./piechart.template.html'),
        data: function () {
            return {
                sections: []
            }
        },
        computed: {

        },
        created: function () {
            if (this.parts !== undefined) {
                var pathLength = 2*Math.PI*16;
                var pieces = this.parts.split('|');
                var total = 0;
                if (this.total !== undefined) {
                    total = this.total;
                } else {
                    pieces.forEach(function (piece) {
                        total += parseFloat(piece.split(',')[0]);
                    });
                    pieces.sort(function(a,b){
                            var ap = parseFloat(a.split(',')[0])/total;
                            var bp = parseFloat(b.split(',')[0]/total);
                            return ap < bp;
                        }
                    );
                }
                var offset = 0;
                var instance = this;
                pieces.forEach(function (piece) {
                    var vals = piece.split(',');
                    var section = {
                        color: vals[1],
                        offset: -offset,
                        percent: parseFloat(vals[0]) / total * 100
                    };
                    instance.sections.push(section);
                    offset += section.percent;
                });
            }
        }
    });
};