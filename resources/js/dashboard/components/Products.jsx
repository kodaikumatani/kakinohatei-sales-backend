import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Paper, Grid } from '@mui/material';
import {
    BarChart,
    Bar,
    Cell,
    XAxis,
    YAxis,
    CartesianGrid,
    ResponsiveContainer
} from 'recharts';
import { COLORS } from '../../layouts/Styles';
import Legend from './Legend';
import Title from './Title';

const Products = (props) => {
    const { date } = props;
    const [products, setProducts] = useState([]);

    useEffect(() => {
        axios.get(`/api/sales/daily/${date}/products`)
            .then(response => setProducts(response.data.details))
            .catch(error => console.log(error))
    }, [date]);

    return (
        <Paper
            sx={{
                p: 2,
                display: 'flex',
                flexDirection: 'column',
            }}
        >
            <Title>Products</Title>
            <Grid container alignItems="center" justifyContent="center">
                <Grid item xs={7}>
                    <ResponsiveContainer width="90%" aspect="1.1">
                        <BarChart
                            data={products}
                            margin={{ top: 20, right: 0, bottom: 0, left: 0 }}
                            barCategoryGap={`${(7-products.length)*7}%`}
                        >
                            <CartesianGrid horizontal={true} vertical={false} />
                            <Bar dataKey="value">
                                {products.map((product, index) => (
                                    <Cell
                                        key={`cell-${index}`}
                                        fill={COLORS[index % COLORS.length]}
                                    />
                                ))}
                            </Bar>
                            <XAxis dataKey="name" interval={0} style={{fontSize: '0.8rem'}}/>
                            {/*<YAxis />*/}
                        </BarChart>
                    </ResponsiveContainer>
                </Grid>
                <Grid item xs={5}>
                    <Legend items={products} />
                </Grid>
            </Grid>
        </Paper>
    );
}
export default Products;
