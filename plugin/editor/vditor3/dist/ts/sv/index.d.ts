/// <reference types="./types" />
declare class Editor {
    element: HTMLPreElement;
    composingLock: boolean;
    processTimeoutId: number;
    hlToolbarTimeoutId: number;
    preventInput: boolean;
    constructor(vditor: IVditor);
    private copy;
    private bindEvent;
}
export { Editor };
