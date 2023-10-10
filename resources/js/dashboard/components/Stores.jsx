import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Grid, Paper } from '@mui/material';
import { PieChart, Pie, Cell, Label, ResponsiveContainer } from 'recharts';
import { COLORS } from '../../layouts/Styles';
import Legend from './Legend';
import Title from './Title';

const Stores= (props) => {
    const { date } = props;
    const [stores, setStores] = useState([]);
    const total = new Intl.NumberFormat().format(stores.reduce(function (sum, element) {
        return sum + element.value;
    }, 0));

    useEffect(() => {
        axios.get(`/api/sales/daily/${date}/stores`)
            .then(response => setStores(response.data.details))
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
            <Title>Sales</Title>
            <Grid container alignItems="center">
                <Grid item xs={5} >
                    <ResponsiveContainer width="90%" aspect="1">
                        <PieChart onClick={null}>
                            <Pie
                                data={stores}
                                innerRadius="75%"
                                outerRadius="90%"
                                fill="#8884d8"
                                dataKey="value"
                            >
                                <Label position="center" style={{ fontSize: '1.2rem' }}>
                                    {"¥" + total}
                                </Label>
                                {stores.map((store, index) => (
                                    <Cell
                                        key={`cell-${index}`}
                                        fill={COLORS[index % COLORS.length]}
                                    />
                                ))}
                            </Pie>
                        </PieChart>
                    </ResponsiveContainer>
                </Grid>
                <Grid item xs={7}>
                    <Legend items={stores} />
                </Grid>
            </Grid>
        </Paper>
    );
}

export default Stores;
