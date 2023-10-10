import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { TableContainer, Table, TableBody, TableCell, TableHead, TableRow } from '@mui/material';

const SalesTable= (props) => {
    const { date, query } = props
    const NWC = new Intl.NumberFormat();
    const [sales, setSales] = useState([]);

    useEffect(() => {
        axios.get(`/api/sales/daily/${date}${query}`)
            .then(response => setSales(response.data.details))
            .catch(error => console.log(error))
    }, [date, query]);
    return (
        <TableContainer>
            <Table size="small" sx={{ tableLayout: 'fixed' }}>
                <TableHead>
                    <TableRow sx={{ whiteSpace: 'nowrap' }}>
                        <TableCell>商品名</TableCell>
                        <TableCell align="right">単価</TableCell>
                        <TableCell align="right">数量</TableCell>
                        <TableCell align="right">合計額</TableCell>
                        <TableCell align="right">店舗計</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                    {sales.map((entry, index) => (
                        <TableRow key={index} sx={{ whiteSpace: 'nowrap' }}>
                            <TableCell>{entry.product}</TableCell>
                            <TableCell align="right">{entry.price}</TableCell>
                            <TableCell align="right">{entry.quantity}</TableCell>
                            <TableCell align="right">{`${NWC.format(entry.total)}`}</TableCell>
                            <TableCell align="right">{entry.store_total}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </TableContainer>
    );
}

export default SalesTable;
