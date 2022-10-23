import React from 'react';
import moment from 'moment'
import {getRangeDaysAsKeys, round} from "../../functions/CommonFunctions";
import UserContext from "../../entity/UserContext";
import {requestWithAuthCheck} from "../../functions/RequestFunctions";
import CalendarBlock from "./CalendarBlock";
import OperationChart from "./OperationChart";
import {NotificationInfo} from "../../functions/NotificationFunctions";

export default class OperationBlock extends React.Component {
    static contextType = UserContext;

    constructor(props) {
        super(props);

        this.state = {
            operations: [],
            operationsByDays: {},
            operationsByDescriptions: [],
            rangeOfDays: [],
            statistic: {
                sumOperation: 0,
            },
            operationFilters: {
                selectDay: null,
                from: moment().subtract(1, 'month').format('YYYY-MM-DD'),
                to: moment().format('YYYY-MM-DD')
            },
        };

        this.setFromDate = this.setFromDate.bind(this);
        this.setToDate = this.setToDate.bind(this);
        this.setSelectDay = this.setSelectDay.bind(this);
        this.getAmountForDate = this.getAmountForDate.bind(this);
        this.getCurrentDay = this.getCurrentDay.bind(this);
        this.sendToArchive = this.sendToArchive.bind(this);
    }

    setFromDate(event) {
        let state = this.state;
        state.operationFilters.from = event.target.value;

        this.setState(state, this.setOperations)
    }

    setToDate(event) {
        let state = this.state;
        state.operationFilters.to = event.target.value;

        this.setState(state, this.setOperations)
    }

    setSelectDay(event) {
        let state = this.state;
        state.operationFilters.selectDay = event.target.getAttribute('data-date');

        this.setState(state)
    }

    componentDidMount() {
        this.setOperations()
    }

    groupOperationsByDescriptions() {
        let operationsByDescriptions = {};

        this.state.operations.map(function (operation) {
            if (operationsByDescriptions[operation.description] === undefined) {
                operationsByDescriptions[operation.description] = {
                    amount: 0,
                    description: operation.description,
                    operations: [],
                };
            }

            operationsByDescriptions[operation.description].amount = round(operationsByDescriptions[operation.description].amount + operation.amount);
            operationsByDescriptions[operation.description].operations.push(operation);
        })

        operationsByDescriptions = Object.keys(operationsByDescriptions).map((key) => operationsByDescriptions[key]);

        this.setState({
            operationsByDescriptions: operationsByDescriptions.sort(this.sortByAmount)
        });
    }

    sortByAmount(a, b) {
        return a.amount < b.amount ? 1 :
            a.amount > b.amount ? -1 : 0;
    }

    groupOperationsByDays() {
        let operationsByDays = {};

        this.state.operations.map(function (operation) {
            let date = moment(operation.date).format('DD-MM-YYYY');

            if (operationsByDays[date] === undefined) {
                operationsByDays[date] = {
                    amount: 0,
                    operations: [],
                };
            }

            operationsByDays[date].amount = round(operationsByDays[date].amount + operation.amount);
            operationsByDays[date].operations.push(operation);
        })

        this.setState({
            operationsByDays: operationsByDays
        });
    }

    setStatistic() {
        let sumOperation = 0;

        this.state.operations.map(function (operation) {
            sumOperation += operation.amount;
        })

        this.setState({
            statistic: {sumOperation: round(sumOperation)},
        });
    }

    getAmountForDate(date) {
        return this.state.operationsByDays[date] === undefined
            ? 0
            : this.state.operationsByDays[date].amount;
    }

    getCurrentDay() {
        return this.state.operationsByDays[this.state.operationFilters.selectDay] === undefined
            ? {operations: []}
            : this.state.operationsByDays[this.state.operationFilters.selectDay]
    }

    setOperations() {
        requestWithAuthCheck(
            '/api/v1/operations',
            'GET',
            {
                filters: {
                    from: this.state.operationFilters.from,
                    to: this.state.operationFilters.to,
                }
            },
            {
                'Authorization': 'Bearer ' + this.context.state.token
            }
        ).then(response => {
            let rangeOfDays = getRangeDaysAsKeys(this.state.operationFilters.from, this.state.operationFilters.to);

            this.setState({
                operations: response.result,
                rangeOfDays
            }, function () {
                this.groupOperationsByDescriptions();
                this.groupOperationsByDays();
                this.setStatistic();
            });
        });
    }

    sendToArchive(event) {
        requestWithAuthCheck(
            '/api/v1/operations/archive',
            'POST',
            {
                id: parseInt(event.target.getAttribute('data-id'))
            },
            {
                'Authorization': 'Bearer ' + this.context.state.token
            }
        ).then(response => {
            NotificationInfo('Archived')

            this.setOperations();
        })
    }

    render() {
        return (
            <div>
                <div className="row">
                    <div className="form-group">
                        <div className="input-group">
                            <div className="input-group-prepend">
                                <span className="input-group-text" id="inputGroup-sizing-sm">From</span>
                            </div>

                            <input value={this.state.operationFilters.from || ''}
                                   onChange={this.setFromDate}
                                   type="date"
                                   className="form-control"/>

                            <div className="input-group-prepend" style={{marginLeft: '10px'}}>
                                <span className="input-group-text" id="inputGroup-sizing-sm">To</span>
                            </div>

                            <input value={this.state.operationFilters.to || ''}
                                   onChange={this.setToDate}
                                   type="date"
                                   className="form-control"/>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-md-9">
                        <CalendarBlock
                            rangeOfDays={this.state.rangeOfDays}
                            getAmountForDate={this.getAmountForDate}
                            selectDay={this.setSelectDay}/>
                    </div>

                    <div className="col-md-3">
                        <div style={{marginBottom: "20px"}}>
                            SUM: <span style={{fontWeight: "bold"}}>{this.state.statistic.sumOperation}</span>
                        </div>

                        <div>
                            {this.state.operationFilters.selectDay ? (
                                <div>Select day: {this.state.operationFilters.selectDay}</div>
                            ) : (
                                <div>For display operations select day</div>
                            )}


                            {this.getCurrentDay().operations.map((operation, index) => {
                                return (
                                    <div key={index} style={styles.operationBlock}>
                                        <i onClick={this.sendToArchive}
                                           data-id={operation.id}
                                           style={styles.archiveI}
                                           className="fa-solid fa-box-archive"></i>

                                        <span style={styles.spanAmount}>{operation.amount}</span>
                                        &nbsp;-&nbsp;
                                        <span style={styles.spanDescription}>{operation.description}</span>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-md-8">
                        <OperationChart operations={this.state.operationsByDescriptions}/>
                    </div>
                </div>
            </div>
        );
    }
}

const styles = {
    operationBlock: {
        marginTop: "15px"
    },
    spanAmount: {
        color: "rgb(80 193 45)",
        fontWeight: 'bold'
    },
    spanDescription: {
        fontSize: "0.8em"
    },
    descriptionContainer: {
        display: "flex",
        flexWrap: "wrap",
        width: "100%",
    },
    descriptionItem: {
        margin: "10px",
        minWidth: "150px",
        maxWidth: "3000px"
    },
    archiveI: {
        color: "#ff6e6e",
        marginRight: "10px",
        cursor: "pointer"
    }
};
