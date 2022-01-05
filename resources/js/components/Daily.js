import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Link from '@material-ui/core/Link';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import Title from './Title';

function preventDefault(event) {
  event.preventDefault();
}

const useStyles = makeStyles({
  depositContext: {
    flex: 1,
  },
});

export default function Deposits() {
  const classes = useStyles();
  
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
        ¥
        {daily.map((d) => (d.sales))}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {daily.map((d) => (d.received))}
      </Typography>
    </React.Fragment>
  );
}