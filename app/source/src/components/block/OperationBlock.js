import React from 'react';
import UserContext from "../../entity/UserContext";
import {requestWithAuthCheck} from "../../functions/RequestFunctions";

export default class OperationBlock extends React.Component {
    static contextType = UserContext;

    state = {
        operations: []
    };

    constructor(props) {
        super(props);
    }

    componentDidMount() {
        this.getOperations().then(data => {
            this.setState({
                operations: data.result
            });
        })
    }

    getOperations() {
        return requestWithAuthCheck(
                '/api/v1/operations',
                'GET',
                null,
                {
                    'Authorization': 'Bearer ' + this.context.state.token
                }
        );
    }

    render() {
        return (
                <div className="row">
                    <div className="col-md-8">
                        dd
                    </div>

                    <div className="col-md-4">
                        {this.state.operations.map((operation, index) => {
                            return (
                                    <div key={index}>
                                        <div style={{
                                            color: "rgb(80 193 45)",
                                            'font-weight': 'bold'
                                        }}>{operation.amount}</div>
                                        <div>{operation.description}</div>
                                    </div>
                            );
                        })}
                    </div>
                </div>
        );
    }
}
