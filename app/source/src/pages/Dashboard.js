import React from 'react';
import OperationBlock from "../components/block/OperationBlock";

export default class DashboardPage extends React.Component {
    constructor(props) {
        super(props)
    }

    render() {
        return (
                <div>
                    <OperationBlock/>
                </div>
        );
    }
}
