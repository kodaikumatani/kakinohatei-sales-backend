import React from 'react';
import { useTheme } from '@material-ui/core/styles';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, ResponsiveContainer } from 'recharts';
import Title from './Title';

export default function Chart(props) {
  const theme = useTheme();
  
  const renderCustomBarLabel = ({ payload, x, y, width, height, value }) => {
    return <text x={x + width / 2} y={y} fill="#666" textAnchor="middle" dy={-6}>{`${value}`}</text>;
  };
  return (
    <React.Fragment>
      <Title>Sales trends</Title>
      <ResponsiveContainer width="100%" height="100%">
        <BarChart
          width={500}
          height={300}
          data={props.value}
          margin={{
            top: 5,
            right: 30,
            left: 20,
            bottom: 5,
          }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="time" />
          <YAxis />
          <Bar dataKey="amount" fill={theme.palette.info.main} label={renderCustomBarLabel} />
        </BarChart>
      </ResponsiveContainer>
    </React.Fragment>
  );
}