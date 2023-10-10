import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Paper } from '@mui/material';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, ResponsiveContainer } from 'recharts';
import Title from './Title';

const HourlySales = (props) => {
    const { date } = props;
    const [hours, setHours] = useState([{ hour: 19, value: 0}]);

    useEffect(() => {
        axios.get(`/api/sales/${date}/hourly`)
            .then(response => setHours(response.data.summary))
            .catch(error => console.log(error))
    }, [date])

    return (
        <Paper
            sx={{
                p: 2,
                display: 'flex',
                flexDirection: 'column',
            }}
        >
            <Title>Hourly Sales</Title>
            <ResponsiveContainer aspect="2">
                <BarChart
                    data={hours}
                    margin={{ top: 30, right: 0, bottom: 0, left: 0 }}
                    barCategoryGap={"20%"}
                >
                    <CartesianGrid horizontal={true} vertical={false} />
                    <Bar dataKey="value" fill="#1492C9" />
                    <XAxis
                        dataKey="hour"
                        type="number"
                        interval={0}
                        domain={['dataMin - 1', 'dataMax + 1']}
                        ticks={[10, 11, 12, 13, 14, 15, 16, 17, 18, 19]}
                    />
                    <YAxis />
                </BarChart>
            </ResponsiveContainer>
        </Paper>
    );
}
export default HourlySales;
