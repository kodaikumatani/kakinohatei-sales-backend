import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { TableContainer, Table, TableBody, TableCell, TableHead, TableRow } from '@mui/material';

const SalesTable = props => {
  const { data } = props;
  const NWC = new Intl.NumberFormat();

  return (
    <TableContainer>
      <Table size='small' sx={{ tableLayout: 'fixed' }}>
        <TableHead>
          <TableRow sx={{ whiteSpace: 'nowrap' }}>
            <TableCell>商品名</TableCell>
            <TableCell align='right'>単価</TableCell>
            <TableCell align='right'>数量</TableCell>
            <TableCell align='right'>合計額</TableCell>
            <TableCell align='right'>店舗計</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {data.map((entry, index) => (
            <TableRow key={index} sx={{ whiteSpace: 'nowrap' }}>
              <TableCell>{entry.name}</TableCell>
              <TableCell align='right'>{entry.price}</TableCell>
              <TableCell align='right'>{entry.quantity}</TableCell>
              <TableCell align='right'>{`${NWC.format(entry.total)}`}</TableCell>
              <TableCell align='right'>{entry.store_total}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
};

export default SalesTable;
