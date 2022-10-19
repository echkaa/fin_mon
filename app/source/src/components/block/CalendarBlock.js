import React from 'react';

export default class CalendarBlock extends React.Component {
    getDataRows(dataObject) {
        let rows = [],
            emptyRow = [null, null, null, null, null, null, null],
            currentRow = [...emptyRow];

        dataObject.map(function (item, index) {
            if (item.newLine) {
                rows.push(currentRow);
                currentRow = [...emptyRow];
            }

            currentRow[index % 7] = item;
        });

        rows.push(currentRow);

        return rows;
    }

    render() {
        return (
            <div>
                {this.getDataRows(this.props.data).map((row, index) => {
                    return (
                        <ul key={index} style={styles.ul}>
                            {row.map((item, index) => {
                                if (item === null) {
                                    return (
                                        <li key={index} style={styles.liItem}></li>
                                    );
                                }

                                return (
                                    <li key={index} style={{...styles.liItem, ...styles.liItemFilled}}>
                                        <div style={styles.divDate}>{item.date.format('DD.MM')}</div>
                                        <div style={styles.divAmount} data-date={item.date.format('DD.MM.YYYY')}
                                             onClick={this.props.selectDay}>{item.value}</div>
                                    </li>
                                );
                            })}
                        </ul>
                    );
                })}
            </div>
        )
    };
}

const styles = {
    ul: {
        fontSize: "0.8rem",
        display: "table",
        tableLayout: "fixed",
        borderCollapse: "collapse",
        width: "100%",
        marginBottom: 0,
    },
    liItem: {
        display: "table-cell",
        boxSizing: "border-box",
        border: "1px solid #b9b9b9",
    },
    liItemFilled: {
        padding: "0.4vw",
    },
    divDate: {
        fontSize: "1.4vw",
    },
    divAmount: {
        textAlign: 'right',
        fontWeight: 'bold',
        color: "#12b705",
        fontSize: "2.0vw",
        marginTop: "10px",
    }
};
