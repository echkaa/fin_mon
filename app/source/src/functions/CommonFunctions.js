import moment from 'moment'

/**
 * @param {date|moment} startDate The start date
 * @param {date|moment} endDate The end date
 * @param {string} type The range type. eg: 'days', 'hours' etc
 * @param {function|null} decorateFunction
 */
function getRangeDate(startDate, endDate, type, decorateFunction = null) {
    let fromDate = moment(startDate)
    let toDate = moment(endDate)
    let diff = toDate.diff(fromDate, type)
    let range = []
    for (let i = 0; i <= diff; i++) {
        range.push(moment(startDate).add(i, type))
    }

    if (decorateFunction !== null) {
        return decorateFunction(range)
    }

    return range
}

export function getRangeDaysAsKeys(startDate, endDate) {
    return getRangeDate(
        startDate,
        endDate,
        'days',
        function (range) {
            let decodedRange = [];

            range.map(function (date) {
                decodedRange.push({
                    value: 0,
                    date: date,
                    newLine: parseInt(date.day()) === 1 || parseInt(date.format('DD')) === 1,
                });
            });

            return decodedRange;
        }
    );
}

export function round(number) {
    return Math.round(parseFloat(number) * 100) / 100;
}
