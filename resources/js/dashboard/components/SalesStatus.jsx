import React, { useEffect, useState } from 'react';
import axios from 'axios';
import {
  Box,
  Paper,
  Tab,
  Tabs,
  TableContainer,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
} from '@mui/material';
import TabPanel from './TabPanel';

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

function a11yProps(index) {
  return {
    id: `simple-tab-${index}`,
    'aria-controls': `simple-tabpanel-${index}`,
  };
}

const SalesStatus = props => {
  const { date } = props;
  const [value, setValue] = React.useState(0);
  const [store, setStore] = useState([]);

  useEffect(() => {
    axios
      .get(`/api/sales/daily/${date}`)
      .then(response => setStore(response.data))
      .catch(error => console.log(error));
  }, [date]);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  return (
    <Paper
      sx={{
        p: 2,
        pt: 1,
        display: 'flex',
        flexDirection: 'column',
        minHeight: '270px',
      }}
    >
      <Box>
        <Tabs
          value={value}
          onChange={handleChange}
          variant='scrollable'
          scrollButtons='auto'
          aria-label='scrollable auto tabs example'
        >
          {store.map((entry, index) => (
            <Tab key={index} label={entry.store} {...a11yProps(index)} />
          ))}
        </Tabs>
      </Box>
      {store.map((entry, index) => (
        <TabPanel key={index} value={value} index={index}>
          <SalesTable data={entry.details} />
        </TabPanel>
      ))}
    </Paper>
  );
};

export default SalesStatus;
