import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Paper, Tabs, Tab, Box } from '@mui/material';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, ResponsiveContainer } from 'recharts';
import TabPanel from './TabPanel';

const SalesBar = props => {
  const { hours } = props;

  return (
    <ResponsiveContainer aspect='2'>
      <BarChart
        data={hours}
        margin={{ top: 30, right: 10, bottom: 0, left: -20 }}
        barCategoryGap={'20%'}
      >
        <CartesianGrid horizontal={true} vertical={false} />
        <Bar dataKey='value' fill='#1492C9' label={{ position: 'top' }} />
        <XAxis dataKey='hour' />
        <YAxis />
      </BarChart>
    </ResponsiveContainer>
  );
};

const HourlyFormat = props => {
  const hours = [10, 11, 12, 13, 14, 15, 16, 17, 18, 19];
  hours.map(item => {
    const existData = props.some(data => {
      return data.hour === item;
    });

    if (!existData) {
      props.push({ hour: item });
    }
  });

  return props;
};

function a11yProps(index) {
  return {
    id: `simple-tab-${index}`,
    'aria-controls': `simple-tabpanel-${index}`,
  };
}

const HourlySales = props => {
  const { date } = props;
  const [hours, setHours] = useState([]);
  const [value, setValue] = useState(0);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  useEffect(() => {
    axios
      .get(`/api/sales/${date}/hourly`)
      .then(response => {
        setHours(response.data);
        setValue(0);
      })
      .catch(error => console.log(error));
  }, [date]);

  return (
    <Paper
      sx={{
        p: 1,
        display: 'flex',
        flexDirection: 'column',
      }}
    >
      <Box sx={{ width: '100%' }}>
        <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
          <Tabs value={value} onChange={handleChange} aria-label='basic tabs example'>
            {hours.map((entry, index) => (
              <Tab key={index} label={entry.store} {...a11yProps(index)} />
            ))}
          </Tabs>
        </Box>
        {hours.map((entry, index) => (
          <TabPanel key={index} value={value} index={index}>
            <SalesBar hours={HourlyFormat(entry.details)} />
          </TabPanel>
        ))}
      </Box>
    </Paper>
  );
};

export default HourlySales;
