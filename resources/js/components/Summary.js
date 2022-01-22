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
  const [summary, setSummary] = useState([]);
  useEffect(() => {
    getSummary()
  },[])
  const getSummary = async () => {
    const response = await axios.get('/api/sales');
    setSummary(response.data.summary)
  }
  
  return (
    <React.Fragment>
      <Title>Daily</Title>
      <Typography component="p" variant="h4">
        ¥{numberWithComma.format(summary.daily)}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {summary.received}
      </Typography>
      <Title>Monthly</Title>
      <Typography component="p" variant="h4">
        ¥{numberWithComma.format(summary.monthly)}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {summary.received}
      </Typography>
    </React.Fragment>
  );
}