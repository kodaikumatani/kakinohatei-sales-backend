import React, { useState, useEffect } from 'react';
import axios from 'axios';
import PropTypes from 'prop-types';
import Tabs from '@mui/material/Tabs';
import { Paper } from '@mui/material';
import Tab from '@mui/material/Tab';
import Box from '@mui/material/Box';
import SalesBar from './SalesBar';
import Title from './Title';

function CustomTabPanel(props) {
  const { children, value, index, ...other } = props;

  return (
    <div
      role='tabpanel'
      hidden={value !== index}
      id={`simple-tabpanel-${index}`}
      aria-labelledby={`simple-tab-${index}`}
      {...other}
    >
      {value === index && <Box>{children}</Box>}
    </div>
  );
}

CustomTabPanel.propTypes = {
  children: PropTypes.node,
  index: PropTypes.number.isRequired,
  value: PropTypes.number.isRequired,
};

function a11yProps(index) {
  return {
    id: `simple-tab-${index}`,
    'aria-controls': `simple-tabpanel-${index}`,
  };
}

const BasicTab = props => {
  const { date } = props;
  const [hours, setHours] = useState([]);
  const [value, setValue] = useState(0);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };

  useEffect(() => {
    axios
      .get(`/api/sales/${date}/hourly`)
      .then(response => setHours(response.data))
      .catch(error => console.log(error));
  }, [date]);

  return (
    <Paper
      sx={{
        p: 2,
        display: 'flex',
        flexDirection: 'column',
      }}
    >
      <Title>Hourly Sales</Title>
      <Box sx={{ width: '100%' }}>
        <Box sx={{ borderBottom: 1, borderColor: 'divider' }}>
          <Tabs value={value} onChange={handleChange} aria-label='basic tabs example'>
            {hours.map((entry, index) => (
              <Tab key={index} label={entry.store} {...a11yProps(index)} />
            ))}
          </Tabs>
        </Box>
        {hours.map((entry, index) => (
          <CustomTabPanel key={index} value={value} index={index}>
            <SalesBar hours={entry.details} />
          </CustomTabPanel>
        ))}
      </Box>
    </Paper>
  );
};

export default BasicTab;
