import React, {Suspense} from "react";
import Router from "./_Router";

const App = () => {

    return (
        <Suspense fallback="Loading...">
            <Router/>
        </Suspense>
    );

};

export default App;
