import React from 'react';
import {Chart as ChartJS, ArcElement, Tooltip, Legend} from 'chart.js';
import {Pie} from 'react-chartjs-2';
import {getArrayRandomColor} from "../../functions/CommonFunctions";

ChartJS.register(ArcElement, Tooltip, Legend);

export default class OperationChart extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            data: {
                labels: [],
                datasets: [],
            }
        }
    }

    getData(operations) {
        return {
            labels: operations.map((operation) => operation.amount + " - " + operation.description),
            datasets: [
                {
                    label: '# of Votes',
                    data: operations.map((operation) => operation.amount),
                    backgroundColor: getArrayRandomColor(Object.keys(operations).length),
                },
            ],
        }
    }

    getConfig() {
        return {
            plugins: {
                legend: {
                    display: true,
                    position: "left"
                }
            }
        }
    }

    render() {
        return (
            <div>
                <Pie data={this.getData(this.props.operations)} options={this.getConfig()}/>
            </div>
        );
    }
}
