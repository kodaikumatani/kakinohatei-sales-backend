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

export default function Daily() {
  const classes = useStyles();
  const numberWithComma = new Intl.NumberFormat();
  const [daily, setDaily] = useState([]);
  useEffect(() => {
    getDaily()
  },[])
  const getDaily = async () => {
    const response = await axios.get('/api/sales');
    setDaily(response.data.daily)
  }
  
  return (
    <React.Fragment>
      <Title>Daily Sales</Title>
      <Typography component="p" variant="h4">
        ¥{numberWithComma.format(daily.sales)}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {daily.received}
      </Typography>
    </React.Fragment>
  );
}