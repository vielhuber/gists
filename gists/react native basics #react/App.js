// App.js
import React, {
    useState,
    useEffect
} from 'react'; /* always use { Component } here, despite it is not necessary */
import {
    StyleSheet,
    Text,
    View,
    Image,
  TouchableOpacity
} from 'react-native'; /* how to import react native components */
import ImportExample from './components/ImportExample'; /* how to import other components */
import Grid from './components/Grid';

export default function HelloWorldApp() {
    return (
        <View style={styles.container}>
            <Text>Hello, world!</Text>
            <DummyImage pic="Bananavarieties.jpg" />
            <ImportExample />
            {/*
                    comments in jsx
                    <ImportExample></ImportExample> is also possible
                */}
        </View>
    );
}

function DummyImage(props) {
    /* state */
    const [show, setShow] = useState(false);

    /* events */
    // componentDidMount
    useEffect(() => {
        setShow(true);
      	setShow(prev => !prev);
        /* modify objects */
        /*
        setShow({
            ...obj,
            newProp: false
        });
        let newObj = {...obj};
        newObj[1337][42] = 1;
        setObj(newObj);
        */
    }, []);
    // componentDidMount / componentDidUpdate
    useEffect(() => {});

    if (props.pic === null || show === false) {
        return <Text>Empty</Text>;
    }

    let pic = {
        uri: 'https://upload.wikimedia.org/wikipedia/commons/d/de/' + props.pic
    };

    return (
        <View>
            <TouchableOpacity
                onPress={() => {
                    console.log('does not work');
                }}
            >
                <Image source={pic} style={{ width: 193, height: 110 }} />
            </TouchableOpacity>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center'
    }
});
