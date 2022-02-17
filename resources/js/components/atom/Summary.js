import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import Title from './Title';

const useStyles = makeStyles({
  depositContext: {
    flex: 1,
  },
});

export default function Summary(props) {
  const classes = useStyles();
  const numberWithComma = new Intl.NumberFormat();
  
  return (
    <React.Fragment>
      <Title>Daily</Title>
      <Typography component="p" variant="h4">
        ¥{numberWithComma.format(props.value.daily)}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {props.value.received}
      </Typography>
      <Title>Monthly</Title>
      <Typography component="p" variant="h4">
        ¥{numberWithComma.format(props.value.monthly)}
      </Typography>
      <Typography color="textSecondary" className={classes.depositContext}>
        {props.value.received}
      </Typography>
    </React.Fragment>
  );
}