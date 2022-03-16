import React from 'react';
import PropTypes from 'prop-types';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';

const useStyles = makeStyles((theme) => ({
  root: {
    color: theme.palette.info.dark
  },
}));

export default function Title(props) {
  const classes = useStyles();

  return (
    <Typography className={classes.root} component="h2" variant="h6" gutterBottom>
      {props.children}
    </Typography>
  );
}

Title.propTypes = {
  children: PropTypes.node,
};