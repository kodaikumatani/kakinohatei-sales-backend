import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import Title from './Title';

const useStyles = makeStyles({
  depositContext: {
    flex: 1,
  },
});

export default function Monthly() {
  const classes = useStyles();
  const numberWithComma = new Intl.NumberFormat();
  const [monthly, setMonthly] = useState([]);
  useEffect(() => {
    getMonthly()
  },[])
  const getMonthly = async () => {
    const response = await axios.get('/api/sales');
    setMonthly(response.data.monthly)
  }
  
  return (
    <React.Fragment>
      <Title>Monthly Sales</Title>
      <Typography component="p" variant="h4">
        ¥{numberWithComma.format(monthly.sales)}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {monthly.received}
      </Typography>
    </React.Fragment>
  );
}