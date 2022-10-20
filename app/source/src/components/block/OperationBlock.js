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
            operationsByDay: [],
            operationsByRange: [],
            operationFilters: {
                selectDay: null,
                from: moment().subtract(1, 'month').format('YYYY-MM-DD'),
                to: moment().format('YYYY-MM-DD')
            },
        };

        this.setFromDate = this.setFromDate.bind(this);
        this.setToDate = this.setToDate.bind(this);
        this.setSelectDay = this.setSelectDay.bind(this);
    }

    setFromDate(event) {
        let state = this.state;
        state.operationFilters.from = event.target.value;

        this.setState(state)
    }

    setToDate(event) {
        let state = this.state;
        state.operationFilters.to = event.target.value;

        this.setState(state)
    }

    setSelectDay(event) {
        let state = this.state;
        state.operationFilters.selectDay = event.target.getAttribute('data-date');

        this.setState(state, this.setOperationForDay)
    }

    componentDidMount() {
        this.setOperations()
    }

    setOperationForDay() {
        let operationsByDay = this.state.operations,
            selectDay = this.state.operationFilters.selectDay;

        operationsByDay = operationsByDay.filter((operation) => operation.date === selectDay);

        this.setState({
            operationsByDay
        })
    }

    fillOperationsByRange() {
        let operationsByRange = this.state.operationsByRange;

        operationsByRange.map(function (item) {
            item.value = Math.floor(Math.random() * 10000);

            return item;
        })

        this.setState({
            operationsByRange
        });
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
            let operationsByRange = getRangeDaysAsKeys(this.state.operationFilters.from, this.state.operationFilters.to);

            this.setState({
                operations: response.result,
                operationsByDay: response.result,
                operationsByRange
            }, this.fillOperationsByRange);
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
                        <CalendarBlock data={this.state.operationsByRange} selectDay={this.setSelectDay}/>
                    </div>

                    <div className="col-md-3">
                        {this.state.operationsByDay.map((operation, index) => {
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
