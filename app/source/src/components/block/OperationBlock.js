import React from 'react';
import moment from 'moment'
import {getRangeDaysAsKeys} from "../../functions/CommonFunctions";
import UserContext from "../../entity/UserContext";
import {requestWithAuthCheck} from "../../functions/RequestFunctions";
import CalendarBlock from "./CalendarBlock";

export default class OperationBlock extends React.Component {
    static contextType = UserContext;

    constructor(props) {
        super(props);

        this.state = {
            operations: [],
            operationsByDays: {},
            rangeOfDays: [],
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

            operationsByDays[date].amount += operation.amount;
            operationsByDays[date].operations.push(operation);
        })

        this.setState({
            operationsByDays: operationsByDays
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
                    fromDate: this.state.operationFilters.from,
                    toDate: this.state.operationFilters.to,
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
            }, this.groupOperationsByDays);
        });
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
                        {this.state.operationFilters.selectDay ? (
                            <div>Select day: {this.state.operationFilters.selectDay}</div>
                        ) : (
                            <div>For display operations select day</div>
                        )}


                        {this.getCurrentDay().operations.map((operation, index) => {
                            return (
                                <div key={index}>
                                    <div style={{
                                        color: "rgb(80 193 45)",
                                        fontWeight: 'bold'
                                    }}>{operation.amount}</div>

                                    <div>{operation.description}</div>
                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>
        );
    }
}
